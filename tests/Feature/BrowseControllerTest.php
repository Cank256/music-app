<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class BrowseControllerTest extends TestCase
{
    protected $response;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function testIndex()
    {
        $this->get('/browse')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Browse')
                ->has('topTags', function (AssertableJson $topTags) {
                    return $topTags->each(fn ($tag) =>
                        $tag->has('name')
                    );
                })
            );
    }

    public function testGetTag()
    {
        $this->get('/tag?tag=rock')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Tag')
                ->has('tag', function (AssertableJson $tag) {
                    return $tag
                        ->has('name')
                        ->has('summary');
                })
                ->has('artists', function (AssertableJson $artists) {
                    return $artists->each(fn ($artist) =>
                        $artist->has('name') &&
                        $artist->has('mbid') &&
                        $artist->has('image') &&
                        $artist->has('rank')
                    );
                })
                ->has('albums', function (AssertableJson $albums) {
                    return $albums->each(fn ($album) =>
                        $album->has('name') &&
                        $album->has('image') &&
                        $album->has('artist') &&
                        $album->has('rank')
                    );
                })
            );
    }
}
