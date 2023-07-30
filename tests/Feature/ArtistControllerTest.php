<?php

namespace Tests\Feature;

use App\Http\Controllers\ArtistController;
use App\Models\Favorite;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
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

    public function test_get_artist(): void
    {
        Http::fake([
            'endpoint_for_artist_info' => Http::response([
                'artist' => ['name' => 'Artist 1', 'listeners' => '1000000'],
            ]),
            'endpoint_for_top_tracks' => Http::response([
                'topTracks' => [['name' => 'Track 1', 'listeners' => '1000000']],
            ]),
            'endpoint_for_top_albums' => Http::response([
                'topAlbums' => [['name' => 'Album 1', 'listeners' => '1000000']],
            ]),
            'endpoint_for_similar_artists' => Http::response([
                'similarArtists' => [['name' => 'Artist 1', 'listeners' => '1000000']],
            ]),
            // ... any other fakes
        ]);

        $user = User::factory()->create();
        Auth::login($user);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('artist_name', 'Artist 1')
            ->first();


        $this->get('/search/artist?artist=Artist%201')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('SingleArtist')
                ->has('artist', function (Assert $artist) {
                    return $artist
                        ->where('name', 'Artist 1')
                        ->where('listeners', '1000000');
                })
                ->has('topTracks', function (Assert $topTracks) {
                    return $topTracks->first(fn ($track) =>
                        $track['name'] === 'Track 1' && $track['listeners'] === '1000000'
                    );
                })
                ->has('topAlbums', function (Assert $topAlbums) {
                    return $topAlbums->first(fn ($album) =>
                        $album['name'] === 'Album 1' && $album['listeners'] === '1000000'
                    );
                })
                ->has('similarArtists', function (Assert $similarArtists) {
                    return $similarArtists->first(fn ($artist) =>
                        $artist['name'] === 'Artist 1' && $artist['listeners'] === '1000000'
                    );
                })
                ->where('isFavorite', $favorite ? true : false)
            );
    }

    public function test_search_artist(): void
    {
        // Given
        Http::fake([
            '*' => Http::response([
                'similarartists' => [
                    'artist' => [
                        ['name' => 'Similar Artist 1', 'listeners' => '1000000'],
                        ['name' => 'Similar Artist 2', 'listeners' => '500000'],
                        // Add more artist data as needed
                    ],
                ],
            ]),
        ]);

        // Create a reflection of the YourClass to access the private method
        $yourClass = new ArtistController();
        $method = new ReflectionMethod(ArtistController::class, 'getSimilarArtists');
        $method->setAccessible(true);

        // When
        $similarArtists = $method->invokeArgs($yourClass, ['Artist 1']);

        // Then
        $this->assertCount(2, $similarArtists);
        $this->assertEquals('Similar Artist 1', $similarArtists[0]['name']);
        $this->assertEquals('Similar Artist 2', $similarArtists[1]['name']);
    }
}
