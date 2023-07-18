<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Search', [
            'action' => 'search',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Implement your search logic here, searching for artists and albums with the same characters as the query

        // For demo purposes, let's return some dummy data
        $results = [
            'artists' => [
                ['name' => 'The Weeknd', 'image' => 'https://example.com/weeknd.jpg'],
                ['name' => 'Taylor Swift', 'image' => 'https://example.com/taylor.jpg'],
            ],
            'albums' => [
                ['name' => 'Album 1', 'image' => 'https://example.com/album1.jpg'],
                ['name' => 'Album 2', 'image' => 'https://example.com/album2.jpg'],
            ],
        ];

        return response()->json($results);
    }
}
