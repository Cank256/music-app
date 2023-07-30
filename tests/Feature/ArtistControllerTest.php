<?php

namespace Tests\Feature;

use App\Http\Controllers\ArtistController;
use App\Models\Favorite;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\Assert;
use ReflectionMethod;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;

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
        // Mock the HTTP responses
        Http::fake([
            '{api_host_for_artist_info}' => Http::response([
                'artist' => [
                    'name' => 'Artist 1',
                    'listeners' => '1000000',
                    // ...
                ]
            ]),
            '{api_host_for_top_tracks}' => Http::response([
                'topTracks' => [
                    ['name' => 'Track 1', 'listeners' => '1000000'],
                    // ...
                ]
            ]),
            '{api_host_for_top_albums}' => Http::response([
                'topAlbums' => [
                    ['name' => 'Album 1', 'listeners' => '1000000'],
                    // ...
                ]
            ]),
            '{api_host_for_similar_artists}' => Http::response([
                'similarArtists' => [
                    ['name' => 'Artist 1', 'listeners' => '1000000'],
                    // ...
                ]
            ]),
            // ... other APIs
        ]);

        $user = User::factory()->create();

        // Auth mock
        $this->actingAs($user);

        // Simulate existing favorite
        $favorite = Favorite::factory()->create([
            'user_id' => $user->id,
            'artist_name' => 'Artist 1',
        ]);

        // Send request and assert response
        $this->get('/artist?artist=Artist 1')
            ->assertInertia(fn (Assert $page) => $page
                ->component('SingleArtist')
                ->where('artist.name', 'Artist 1')
                ->where('artist.listeners', '1000000')
                ->where('topTracks.0.name', 'Track 1')
                ->where('topTracks.0.listeners', '1000000')
                ->where('topAlbums.0.name', 'Album 1')
                ->where('topAlbums.0.listeners', '1000000')
                ->where('similarArtists.0.name', 'Artist 1')
                ->where('similarArtists.0.listeners', '1000000')
                ->where('isFavorite', true)
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
