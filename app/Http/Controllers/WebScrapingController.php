<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class WebScrapingController extends Controller
{
    /**
     * Retrieves the release date of an album from a given URL.
     *
     * This method uses a web scraping client to fetch the HTML content of the specified URL,
     * and then extracts the release date from the content. Specifically, it looks for elements
     * with the class "catalogue-metadata-description" and extracts the text of the second element
     * if found. If there are fewer than two such elements, the method returns 'N/A'.
     *
     * Note: Web scraping depends on the specific structure of the HTML content, and any changes
     *       to that structure could cause this method to break.
     *
     * @param string $url The URL from which to retrieve the release date.
     * @return \Illuminate\Http\Response A response containing the release date or 'N/A'.
     */
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
