<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class WebScrapingController extends Controller
{
    public static function getReleaseDate($url)
    {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $metadataDescriptionElements = $crawler->filter('.catalogue-metadata-description');

        $secondMetadataDescription = "";

        if ($metadataDescriptionElements->count() >= 2) {
            // The elements are 0-indexed, so we use "1" to get the second one.
            $secondMetadataDescription = $metadataDescriptionElements->eq(1)->text();
        } else {
            $secondMetadataDescription = 'N/A';
        }

        return response()->json([
            'release_date' => $secondMetadataDescription,
        ]);
    }
}
