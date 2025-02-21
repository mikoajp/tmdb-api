<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index($language)
    {
        $movies = Movie::select('id', 'tmdb_id', 'title_' . $language, 'overview_' . $language, 'release_date', 'vote_average', 'vote_count', 'popularity', 'genre_ids')
            ->whereNotNull('title_' . $language)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $movies,
            'total' => $movies->count(),
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
