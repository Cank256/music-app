<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    /**
     * Formats a given response based on a specified context.
     *
     * Depending on the value of the `$for` parameter, it delegates the formatting to one of several specialized
     * methods and returns the result.
     *
     * @param string $for     The context for which the result should be formatted.
     * @param mixed  $result  The data to be formatted.
     * @return mixed          The formatted response, as determined by the specified context.
     */
    public static function formatResponse($for, $result)
    {
        if ($for == 'artist')
        {
            return self::formatArtistResponse($result);
        }
        else if ($for == 'artist-top-albums')
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
        else if ($for == 'tags')
        {
            return self::formatTagsResponse($result);
        }
        else if ($for == 'tag')
        {
            return self::formatTagResponse($result);
        }
        else if ($for == 'tag-top-artists')
        {
            return self::formatTagTopArtistsResponse($result);
        }
        else if ($for == 'tag-top-albums')
        {
            return self::formatTagTopAlbumsResponse($result);
        }
        else
        {
            return $result;
        }
    }

    /**
     * Formats the artist data for a JSON response.
     *
     * @param array $artistData The raw artist data.
     * @return \Illuminate\Http\JsonResponse The formatted JSON response.
     */
    private static function formatArtistResponse($artistData)
    {
        $extractedData = [
            'name' => $artistData['name'] ?? null,
            'mbid' => $artistData['mbid'] ?? null,
            'image' => self::extractImage($artistData['image']) ?? null,
            'listeners' => $artistData['stats']['listeners'] ?? null,
            'summary' => $artistData['bio']['summary'] ?? null,
        ];

        return response()->json($extractedData);
    }

    /**
     * Formats the top albums of an artist.
     *
     * @param array $topAlbums The raw top albums data.
     * @return \Illuminate\Support\Collection The formatted top albums collection.
     */
    private static function formatArtistTopAlbumsResponse($topAlbums)
    {
        return collect($topAlbums)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'mbid' => $item['mbid'] ?? null,
                'artist' => $item['artist']['name'] ?? null,
                'image' => isset($item['image']) ? self::extractImage($item['image']) : null,
            ];
        });
    }

    /**
     * Formats the top tracks of an artist.
     *
     * @param array $topTracks The raw top tracks data.
     * @return \Illuminate\Support\Collection The formatted top tracks collection.
     */
    private static function formatArtistTopTracksResponse($topTracks)
    {
        return collect($topTracks)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'mbid' => $item['mbid'] ?? null,
                'image' => isset($item['image']) ? self::extractImage($item['image']) : null,
                'listeners' => $item['listeners'] ?? null,
                'rank' => $item['@attr']['rank'] ?? null,
            ];
        });
    }

    /**
     * Formats the similar artists data.
     *
     * @param array $similarArtists The raw similar artists data.
     * @return \Illuminate\Support\Collection The formatted similar artists collection.
     */
    private static function formatSimilarArtistResponse($similarArtists)
    {
        return collect($similarArtists)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'image' => isset($item['image']) ? self::extractImage($item['image']) : null,
            ];
        });
    }

    /**
     * Formats the album data for a JSON response.
     *
     * @param array $albumData The raw album data.
     * @return \Illuminate\Http\JsonResponse The formatted JSON response.
     */
    private static function formatAlbumResponse($albumData)
    {
        $extractedData = [
            'name' => $albumData['name'] ?? null,
            'mbid' => $albumData['mbid'] ?? null,
            'url' => $albumData['url'] ?? null,
            'artist' => $albumData['artist'] ?? null,
            'image' => isset($albumData['image']) ? self::extractImage($albumData['image']) : null,
            'listeners' => $albumData['listeners'] ?? null,
            'tracks' => isset($albumData['tracks']['track']) ? self::extractAlbumTracks($albumData['tracks']['track']) : null,
            'tags' => isset($albumData['tags']['tag']) ? self::extractAlbumTags($albumData['tags']??['tag']) : null,
            'summary' => $albumData['wiki']['summary'] ?? null,
        ];

        return response()->json($extractedData);
    }

    /**
     * Formats the similar albums data.
     *
     * @param array $similarAlbums The raw similar albums data.
     * @return \Illuminate\Support\Collection The formatted similar albums collection.
     */
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

    /**
     * Formats the tags data.
     *
     * @param array $tagsData The raw tags data.
     * @return \Illuminate\Support\Collection The formatted tags collection.
     */
    private static function formatTagsResponse($tagsData)
    {
        return collect($tagsData)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null
            ];
        });
    }

    /**
     * Formats the tag data for a JSON response.
     *
     * @param array $tagData The raw tag data.
     * @return \Illuminate\Http\JsonResponse The formatted JSON response.
     */
    private static function formatTagResponse($tagData)
    {
        $extractedData = [
            'name' => $tagData['name'] ?? null,
            'summary' => $tagData['wiki']['summary'] ?? null
        ];

        return response()->json($extractedData);
    }

    /**
     * Formats the top artists data for a given tag.
     *
     * @param array $artistsData The raw artists data.
     * @return \Illuminate\Support\Collection The formatted top artists collection.
     */
    private static function formatTagTopArtistsResponse($artistsData)
    {
        return collect($artistsData)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'mbid' => $item['mbid'] ?? null,
                'image' => isset($albumData['image']) ? self::extractImage($item['image'])[0] : null,
                'rank' => $item['@attr']['rank'] ?? null,
            ];
        });
    }

    /**
     * Formats the top albums data for a given tag.
     *
     * @param array $albumsData The raw albums data.
     * @return \Illuminate\Support\Collection The formatted top albums collection.
     */
    private static function formatTagTopAlbumsResponse($albumsData)
    {
        return collect($albumsData)->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'image' => isset($albumData['image']) ? self::extractImage($item['image'])[0] : null,
                'rank' => $item['@attr']['rank'] ?? null,
            ];
        });
    }

    /**
     * Extracts the URL of an 'extralarge' image from an array of image data.
     *
     * @param array $imageData An array containing image data with 'size' and '#text' keys.
     * @return string|null The URL of the 'extralarge' image, or null if not found.
     */
    private static function extractImage($imageData)
    {
        foreach ($imageData as $image) {
            if ($image['size'] === 'extralarge') {
                $extralargeImageUrl = $image['#text'];
                return $extralargeImageUrl ? $extralargeImageUrl : null;
            }
        }
    }

    /**
     * Extracts the tracks data from an album.
     *
     * @param array $trackData The raw track data.
     * @return \Illuminate\Support\Collection The formatted tracks collection.
     */
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

    /**
     * Extracts the first tag from an array of tag data.
     *
     * @param array $tagData An array containing tag data.
     * @return mixed|null The first tag in the array or null if the array is empty.
     */
    private static function extractAlbumTags($tagData)
    {
        foreach ($tagData as $tag) {
            return $tag;
        }
    }

}
