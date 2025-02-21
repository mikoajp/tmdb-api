<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use App\Contracts\TmdbApiInterface;

class TmdbApiService implements TmdbApiInterface
{
    private $bearerToken;

    public function __construct()
    {
        $this->bearerToken = config('tmdb.api_key');

    }

    /**
     * @throws ConnectionException
     */
    public function getMovies(string $language, int $page = 1): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->bearerToken
        ])->get("https://api.themoviedb.org/3/movie/popular", [
            'language' => $language,
            'page' => $page
        ]);

        return $response->json()['results'];
    }

    /**
     * @throws ConnectionException
     */
    public function getSeries(string $language, int $page = 1): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->bearerToken
        ])->get("https://api.themoviedb.org/3/tv/popular", [
            'language' => $language,
            'page' => $page
        ]);

        return $response->json()['results'];
    }

    /**
     * @throws ConnectionException
     */
    public function getMovieGenres(string $language): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->bearerToken
        ])->get("https://api.themoviedb.org/3/genre/movie/list", [
            'language' => $language
        ]);

        return $response->json()['genres'];
    }

    /**
     * @throws ConnectionException
     */
    public function getSeriesGenres(string $language): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->bearerToken
        ])->get("https://api.themoviedb.org/3/genre/tv/list", [
            'language' => $language
        ]);

        return $response->json()['genres'];
    }
}
