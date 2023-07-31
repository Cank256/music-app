<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public static function formatResponse($for = '', $result)
    {
        if ($for == 'artist')
        {
            return self::formatArtistResponse($result);
        }
        else if ($for == 'artist-to-albums')
        {
            return self::formatArtistTopAlbumsResponse($result);
        }
        else if ($for == 'artist-top-tracks')
        {
            return self::formatArtistTopTracksResponse($result);
        }
        else if ($for == 'similar-artists')
        {
            return self::formatSimilarArtistResponse($result);
        }
        else if ($for == 'album')
        {
            return self::formatAlbumResponse($result);
        }
        else if ($for == 'similar-albums')
        {
            return self::formatSimilarAlbumResponse($result);
        }
    }

    private static function formatArtistResponse($artistData)
    {
        $extractedData = [
            'name' => $artistData['name'] ?? null,
            'mbid' => $artistData['mbid'] ?? null,
            'image' => self::extractImage($artistData['image']),
            'listeners' => $artistData['stats']['listeners'] ?? null,
            'summary' => $artistData['bio']['summary'] ?? null,
        ];

        return response()->json($extractedData);
    }

    private static function formatArtistTopAlbumsResponse($topAlbums)
    {
        return collect($topAlbums)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'mbid' => $item['mbid'] ?? null,
                'artist' => $item['artist']['name'] ?? null,
                'image' => self::extractImage($item['image']),
            ];
        });
    }

    private static function formatArtistTopTracksResponse($topTracks)
    {
        return collect($topTracks)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'mbid' => $item['mbid'] ?? null,
                'image' => self::extractImage($item['image']),
                'listeners' => $item['listeners'] ?? null,
                'rank' => $item['@attr']['rank'] ?? null,
            ];
        });
    }

    private static function formatSimilarArtistResponse($similarArtists)
    {
        return collect($similarArtists)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'image' => self::extractImage($item['image']) ?? [],
            ];
        });
    }

    private static function formatAlbumResponse($albumData)
    {
        $extractedData = [
            'name' => $albumData['name'] ?? null,
            'mbid' => $albumData['mbid'] ?? null,
            'url' => $albumData['url'] ?? null,
            'artist' => $albumData['artist'] ?? null,
            'image' => self::extractImage($albumData['image']) ?? [],
            'listeners' => $albumData['listeners'] ?? null,
            'tracks' => self::extractAlbumTracks($albumData['tracks']['track']) ?? [],
            'tags' => self::extractAlbumTags($albumData['tags']['tag']) ?? [],
            'summary' => $albumData['wiki']['summary'] ?? null,
        ];

        return response()->json($extractedData);
    }

    private static function formatSimilarAlbumResponse($similarAlbums)
    {
        return collect($similarAlbums)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'image' => self::extractImage($item['image']) ?? null,
                'artist' => $item['artist']['name'] ?? null,
                'rank' => $item['@attr']['rank'] ?? null
            ];
        });
    }

    private static function extractImage($imageData)
    {
        $image = collect($imageData)->where('size', 'extralarge')->pluck('#text');
        return $image ? $image : null;
    }

    private static function extractAlbumTracks($trackData)
    {
        return collect($trackData)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'rank' => $item['@attr']['rank'] ?? null,
                'duration' => $item['duration'] ?? null,
            ];
        });
    }

    private static function extractAlbumTags($tagData)
    {
        $tag = collect($tagData)->pluck('name');
        return $tag ? $tag : null;
    }

}
