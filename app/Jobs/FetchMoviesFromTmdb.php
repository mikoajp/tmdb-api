<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Movie;
use App\Contracts\TmdbApiInterface;
use Illuminate\Support\Facades\Log;

class FetchMoviesFromTmdb implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TmdbApiInterface $tmdbApi;

    public function __construct(TmdbApiInterface $tmdbApi)
    {
        $this->tmdbApi = $tmdbApi;
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $languages = ['en-US', 'pl-PL', 'de-DE'];
        $limit = 50;

        foreach ($languages as $language) {
            $this->fetchMovies($language, $limit);
        }
    }

    /**
     * @throws Exception
     */
    private function fetchMovies(string $language, int $limit): void
    {
        $movies = [];
        $page = 1;

        while (count($movies) < $limit) {
            $batch = $this->tmdbApi->getMovies($language, $page);
            $movies = array_merge($movies, $batch);
            $page++;
        }

        $movies = array_slice($movies, 0, $limit);
        $langCode = substr($language, 0, 2);

        foreach ($movies as $movie) {

            try {
                Movie::updateOrCreate(
                    ['tmdb_id' => $movie['id']],
                    [
                        'title_' . $langCode => $movie['title'],
                        'overview_' . $langCode => $movie['overview'],
                        'release_date' => $movie['release_date'],
                        'vote_average' => $movie['vote_average'],
                        'vote_count' => $movie['vote_count'],
                        'popularity' => $movie['popularity'],
                        'genre_ids' => json_encode($movie['genre_ids'])
                    ]
                );
            } catch (Exception $e) {
                Log::error("Failed to save movie ID {$movie['id']} for language {$language}: " . $e->getMessage());
                throw $e;
            }
        }
    }
}
