<?php

namespace Tests\Feature;

use App\Http\Controllers\AlbumController;
use App\Models\User;
use App\Models\Favorite;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use ReflectionMethod;
use Tests\TestCase;

class AlbumControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->withoutExceptionHandling();
    }

    public function test_get_top_albums()
    {
        Http::fake([
            '*' => Http::response([
                'albums' => [
                    'album' => [
                        ['name' => 'Top Album 1', 'artist' => 'Artist 1'],
                        ['name' => 'Top Album 2', 'artist' => 'Artist 2'],
                    ],
                ],
            ]),
        ]);

        // When
        $topAlbums = AlbumController::getTopAlbums();

        // Then
        $this->assertCount(2, $topAlbums);
        $this->assertEquals('Top Album 1', $topAlbums[0]['name']);
        $this->assertEquals('Top Album 2', $topAlbums[1]['name']);
    }

    public function test_get_album()
    {
            $user = User::factory()->create();
            Auth::login($user);

            $favorite = Favorite::where('user_id', $user->id)
                ->where('type', 'album')
                ->where('album_name', 'Album 1')
                ->first();


            $this->get('/search/album?album=Believe&artist=Cher')
                ->assertInertia(fn (AssertableInertia $page) => $page
                    ->component('SingleAlbum')
                    ->has('album', function (AssertableJson $album) {
                        return $album
                            ->has('name')
                            ->has('mbid')
                            ->has('url')
                            ->has('artist')
                            ->has('image')
                            ->has('listeners')
                            ->has('tracks')
                            ->has('tags')
                            ->has('summary');
                    })
                    ->has('similarAlbums', function (AssertableJson $similarAlbums) {
                        return $similarAlbums->each(fn ($album) =>
                            $album->has('name') &&
                            $album->has('artist') &&
                            $album->has('rank') &&
                            $album->has('image')
                        );
                    })
                    ->where('isFavorite', $favorite ? true : false)
                );
    }

    public function test_get_artist_top_albums()
    {
        // Given
        Http::fake([
            '*' => Http::response([
                'similarartists' => [
                    'artist' => [
                        ['name' => 'Similar Artist 1', 'image' => 'https://lastfm.freetls.fastly.net/i/u/300x300/2a96cbd8b46e442fc41c2b86b821562f.png'],
                        ['name' => 'Similar Artist 2', 'image' => 'https://lastfm.freetls.fastly.net/i/u/300x300/2a96cbd8b46e442fc41c2b86b821562f.png'],
                        // Add more artist data as needed
                    ],
                ],
            ]),
        ]);

        // Create a reflection of the YourClass to access the private method
        $albumClass = new AlbumController();
        $method = new ReflectionMethod(AlbumController::class, 'getArtistTopAlbums');
        $method->setAccessible(true);

        $artistTopAlbums = $method->invokeArgs($albumClass, ['Artist 1']);

        $this->assertJson($artistTopAlbums);

    }

    public function test_get_similar_albums()
    {
        Http::fake([
            '*' => Http::response([
                'albums' => [
                    'album' => [
                        ['name' => 'Similar Album', 'artist' => 'Artist 1'],
                    ],
                ],
            ]),
        ]);

        // Create a reflection of the YourClass to access the private method
        $albumClass = new AlbumController();
        $method = new ReflectionMethod(AlbumController::class, 'getArtistTopAlbums');
        $method->setAccessible(true);

        $similarAlbums = $method->invokeArgs($albumClass, ['Artist 1']);

        $this->assertJson($similarAlbums);
    }
}
