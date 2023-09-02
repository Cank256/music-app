<?php

namespace Tests\Feature;

use App\Http\Controllers\ArtistController;
use App\Models\Favorite;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use ReflectionMethod;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->withoutExceptionHandling();
    }

    public function testGetTopArtists()
    {
        // Given
        Http::fake([
            '*' => Http::response([
                'artists' => [
                    'artist' => [
                        ['name' => 'Artist 1', 'listeners' => '1000000'],
                        ['name' => 'Artist 2', 'listeners' => '500000'],
                        // Add more artist data as needed
                    ],
                ],
            ]),
        ]);

        // When
        $topArtists = ArtistController::getTopArtists();

        // Then
        $this->assertCount(2, $topArtists);
        $this->assertEquals('Artist 1', $topArtists[0]['name']);
        $this->assertEquals('Artist 2', $topArtists[1]['name']);
    }

    public function testGetArtist(): void
    {

        $user = User::factory()->create();
        Auth::login($user);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('type', 'artist')
            ->where('artist_name', 'Artist 1')
            ->first();


        $this->get('/artist?artist=Cher')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('SingleArtist')
                ->has('artist', function (AssertableJson $artist) {
                    return $artist
                        ->has('name')
                        ->has('mbid')
                        ->has('listeners')
                        ->has('image')
                        ->has('summary');
                })
                ->has('topTracks', function (AssertableJson $topTracks) {
                    return $topTracks->each(fn ($track) =>
                        $track->has('name') &&
                        $track->has('mbid') &&
                        $track->has('image') &&
                        $track->has('listeners') &&
                        $track->has('rank')
                    );
                })
                ->has('topAlbums', function (AssertableJson $topAlbums) {
                    return $topAlbums->each(fn ($album) =>
                        $album->has('name') &&
                        $album->has('mbid') &&
                        $album->has('image') &&
                        $album->has('artist')
                    );
                })
                ->has('similarArtists', function (AssertableJson $similarArtists) {
                    return $similarArtists->each(fn ($artist) =>
                        $artist->has('name') &&
                        $artist->has('image')
                    );
                })
                ->where('isFavorite', $favorite ? true : false)
            );
    }

    public function testSearchArtist(): void
    {
        // Given
        Http::fake([
            '*' => Http::response([
                'similarartists' => [
                    'artist' => [
                        [
                            'name' => 'Similar Artist 1',
                            'image' => [
                                'size' => 'extralarge',
                                '#text'=> 'https://lastfm.freetls.fastly.net/i/u/300x300/2a96cbd8b46e442fc41c2b86b821562f.png'
                            ]
                        ],
                        [
                            'name' => 'Similar Artist 2',
                            'image' => [
                                'size' => 'extralarge',
                                '#text'=> 'https://lastfm.freetls.fastly.net/i/u/300x300/2a96cbd8b46e442fc41c2b86b821562f.png'
                            ]
                        ],
                        // Add more artist data as needed
                    ],
                ],
            ]),
        ]);

        // Create a reflection of the YourClass to access the private method
        $artistClass = new ArtistController();
        $method = new ReflectionMethod(ArtistController::class, 'getSimilarArtists');
        $method->setAccessible(true);

        // When
        $similarArtists = $method->invokeArgs($artistClass, ['Artist 1']);

        $this->assertArrayHasKey('name', $similarArtists[0]);
        $this->assertArrayHasKey('image', $similarArtists[0]);
    }
}
