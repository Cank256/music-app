<?php

namespace Tests\Feature;

use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;
use App\Models\User;
class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    private $user, $favoriteAlbums, $favoriteArtists;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        // create a user for testing
        $this->user = User::factory()->create();

         // create some favorite albums and artists for the user
         $this->favoriteAlbums = Favorite::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'type' => 'album'
        ]);

        $this->favoriteArtists = Favorite::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'type' => 'artist'
        ]);
    }

    /**
     * Test the index function.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->actingAs($this->user)
            ->get('/library')
            ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Library')
            ->has('favoriteAlbums', 3)  // asserts there are 3 favorite albums
            ->has('favoriteArtists', 3) // asserts there are 3 favorite artists
        );
    }

    /**
     * Test the add function for creating a new favorite if not existing
     * and delete it if it already exists.
     *
     * @return void
     */
    public function testAddFavorite()
    {
        $this->actingAs($this->user);

        $request = [
            'type' => 'album',
            'artist' => 'Test Artist',
            'album' => 'Test Album',
            'mbid' => '70b1e42a-3751-3f29-8c12-0010c9cd847c',
            'image' => 'Test Image',
            'listeners' => 100
        ];

        $response = $this->get('/favorite/add', $request);  // Make sure this is a POST request and the route is correct

        $response->assertRedirect();

        // Check that a favorite was created
        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'type' => $request['type'],
            'artist_name' => $request['artist'],
            'album_name' => $request['album'],
            'mbid' => $request['mbid']
        ]);

    }

}
