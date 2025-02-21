<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Serie;

class SerieController extends Controller
{
    /**
     * Display a listing of all series for a given language.
     *
     * @param string $language
     * @return JsonResponse
     */
    public function index($language)
    {
        $series = Serie::select(
            'id',
            'tmdb_id',
            'name_' . $language,
            'overview_' . $language,
            'first_air_date',
            'vote_average',
            'vote_count',
            'popularity',
            'genre_ids'
        )->whereNotNull('name_' . $language)->get();

        return response()->json([
            'status' => 'success',
            'data' => $series,
            'total' => $series->count(),
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
