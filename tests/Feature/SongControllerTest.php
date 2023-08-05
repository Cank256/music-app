<?php

namespace Tests\Feature;

use App\Http\Controllers\SongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionMethod;
use Tests\TestCase;

class SongControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function test_get_top_albums()
    {
        Http::fake([
            '*' => Http::response([
                'tracks' => [
                    'track' => [
                        [
                            'name' => 'Top Song 1',
                            'listeners' => 1000,
                            'artist' => [
                                'name' =>'Artist 1'
                            ]
                        ],
                        [
                            'name' => 'Top Song 2',
                            'listeners' => 1000,
                            'artist' => [
                                'name' =>'Artist 2'
                            ]
                        ]
                    ],
                ],
            ]),
        ]);

        // When
        $topSongs = SongController::getTopSongs();

        // Then
        $this->assertCount(2, $topSongs);
        $this->assertEquals('Top Song 1', $topSongs[0]['name']);
        $this->assertEquals('Top Song 2', $topSongs[1]['name']);
    }

    public function test_get_artist_top_tracks()
    {
        // Given
        Http::fake([
            '*' => Http::response([
                'toptracks' => [
                    'track' => [
                        ['name' => 'Track 1', 'artist' => 'Artist 1', 'image' => 'https://lastfm.freetls.fastly.net/i/u/300x300/2a96cbd8b46e442fc41c2b86b821562f.png', 'listeners' => 1000, 'rank' => 1],
                        ['name' => 'Track 2', 'artist' => 'Artist 2', 'image' => 'https://lastfm.freetls.fastly.net/i/u/300x300/2a96cbd8b46e442fc41c2b86b821562f.png', 'listeners' => 1000, 'rank' => 2],
                        // Add more artist data as needed
                    ],
                ],
            ]),
        ]);

        // Create a reflection of the YourClass to access the private method
        $songClass = new SongController();
        $method = new ReflectionMethod(SongController::class, 'getArtistTopTracks');
        $method->setAccessible(true);

        $artistTopTracks = $method->invokeArgs($songClass, ['Track 1']);

        $this->assertJson($artistTopTracks);

    }

    public function test_get_track_duration()
    {
        // Mock the HTTP facade
        Http::fake([
            env('LASTFM_HOST') => Http::response([
                'track' => [
                    'duration' => 12345,
                ],
            ]),
        ]);

        Http::fake([
            '*' => Http::response([
                'track' => [
                    'name' => 'Track 1',
                    'duration' => 236000
                ],
            ]),
        ]);

        // Call the method and assert the result
        $duration = SongController::getTrackDuration();
        $this->assertJson($duration);
    }

}
