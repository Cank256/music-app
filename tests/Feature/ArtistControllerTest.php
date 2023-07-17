<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{
    public function testGetTopArtists()
    {
        $response = $this->get('/artists/top');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'name',
                'mbid',
                'url',
                'image',
                'streamable'
            ],
        ]);
    }

    public function testSearchArtist()
    {
        $response = $this->get('/artists/search/artist_name');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'name',
                'mbid',
                'url',
                'image',
                'streamable'
            ],
        ]);
    }
}
