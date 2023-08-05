<?php

namespace Tests\Feature;

use App\Http\Controllers\FavoriteController;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
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

        $requestData = [
            'type' => 'artist',
            'artist' => 'Test Artist',
            'album' => 'Test Album',
            'mbid' => '123456789',
            'image' => 'https://example.com/image.jpg',
            'listeners' => '10000',
        ];

        $request = Request::create('/favorite/add', 'POST', $requestData);

        $controller = new FavoriteController();
        $response = $controller->add($request);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'type' => $requestData['type'],
            'artist_name' => $requestData['artist'],
            'album_name' => $requestData['album'],
            'mbid' => $requestData['mbid'],
            'image' => $requestData['image'],
            'listeners' => $requestData['listeners'],
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(url()->previous(), $response->headers->get('Location'));

    }

}
