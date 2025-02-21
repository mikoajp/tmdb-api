<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Wyświetla listę gatunków w formacie JSON z ograniczeniem do 50 rekordów.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $genres = Genre::all(['id', 'tmdb_id','name_en','name_pl','name_de','created_at']);

        $response = [
            'status' => 'success',
            'data' => $genres,
            'total' => $genres->count(),
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
