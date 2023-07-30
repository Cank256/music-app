<?php

namespace Tests\Feature;

use App\Http\Controllers\AlbumController;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class AlbumControllerTest extends TestCase
{
    use RefreshDatabase;

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
        Http::fake([
            '*' => Http::response([
                'album' => [
                    'name' => 'Album 1',
                    'artist' => 'Artist 1',
                    'tags' => [
                        'tag' => [
                            ['name' => 'Tag 1'],
                        ],
                    ],
                    'url' => 'http://example.com',
                ],
            ]),
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id,
            'artist_name' => 'Artist 1',
            'album_name' => 'Album 1',
        ]);

        $this->get('/album?album=Album 1&artist=Artist 1')
            ->assertInertia(fn (Assert $page) => $page
                ->component('SingleAlbum')
                ->where('album.name', 'Album 1')
                ->where('album.artist', 'Artist 1')
                ->where('similarAlbums.0.name', 'Album 1')
                ->where('releaseDate', '2023-01-01')
                ->where('isFavorite', true)
            );
    }

    public function test_get_artist_top_albums()
    {
        Http::fake([
            '*' => Http::response([
                'topalbums' => [
                    'album' => [
                        ['name' => 'Top Album', 'artist' => 'Artist 1'],
                    ],
                ],
            ]),
        ]);

        // Assuming there's a route defined for this method
        $this->get('/get-artist-top-albums?artist=Artist 1')
            ->assertOk()
            ->assertJsonPath('0.name', 'Top Album')
            ->assertJsonPath('0.artist', 'Artist 1');
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

        // Assuming there's a route defined for this method
        $this->get('/get-similar-albums?tag=Tag 1')
            ->assertOk()
            ->assertJsonPath('0.name', 'Similar Album')
            ->assertJsonPath('0.artist', 'Artist 1');
    }
}
