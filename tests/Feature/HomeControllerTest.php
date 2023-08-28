<?php

namespace Tests\Unit;

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Assert;
use Inertia\Testing\Assert as InertiaAssert;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_returns_home()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Mock the AlbumController, ArtistController, and SongController
        $this->partialMock(AlbumController::class, function ($mock) {
            $mock->shouldReceive('getTopAlbums')->andReturn([
                // Replace with actual data structure
            ]);
        });

        $this->partialMock(ArtistController::class, function ($mock) {
            $mock->shouldReceive('getTopArtists')->andReturn([
                // Replace with actual data structure
            ]);
        });

        $this->partialMock(SongController::class, function ($mock) {
            $mock->shouldReceive('getTopSongs')->andReturn([
                // Replace with actual data structure
            ]);
        });

        $response = $this->get('/'); // assuming your home route is '/'

        $response->assertStatus(200);
        $response->assertInertia(fn (AssertableInertia $page) =>
            $page->component('Home')
                ->has('topAlbums')
                ->has('topArtists')
                //  ->has('topSongs')
        );
    }

    public function test_returns_dashboard()
    {
        // Mock the AlbumController, ArtistController, and SongController
        $this->partialMock(AlbumController::class, function ($mock) {
            $mock->shouldReceive('getTopAlbums')->andReturn([
                // Replace with actual data structure
            ]);
        });

        $this->partialMock(ArtistController::class, function ($mock) {
            $mock->shouldReceive('getTopArtists')->andReturn([
                // Replace with actual data structure
            ]);
        });

        $this->partialMock(SongController::class, function ($mock) {
            $mock->shouldReceive('getTopSongs')->andReturn([
                // Replace with actual data structure
            ]);
        });

        $response = $this->get('/'); // assuming your home route is '/'

        $response->assertStatus(200);
        $response->assertInertia(fn (AssertableInertia $page) =>
            $page->component('Home')
                ->has('topAlbums')
                ->has('topArtists')
                // ->has('topSongs')
        );
    }
}
