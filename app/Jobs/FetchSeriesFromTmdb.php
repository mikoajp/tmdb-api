<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Serie;
use App\Contracts\TmdbApiInterface;
use Illuminate\Support\Facades\Log;

class FetchSeriesFromTmdb implements ShouldQueue
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
        $limit = 10;

        foreach ($languages as $language) {
            $this->fetchSeries($language, $limit);
        }
    }

    /**
     * @throws Exception
     */
    private function fetchSeries(string $language, int $limit): void
    {
        $series = [];
        $page = 1;

        while (count($series) < $limit) {
            $batch = $this->tmdbApi->getSeries($language, $page);
            $series = array_merge($series, $batch);
            $page++;
        }

        $series = array_slice($series, 0, $limit);
        $langCode = substr($language, 0, 2);

        foreach ($series as $serie) {

            try {
                Serie::updateOrCreate(
                    ['tmdb_id' => $serie['id']],
                    [
                        'name_' . $langCode => $serie['name'],
                        'overview_' . $langCode => $serie['overview'],
                        'first_air_date' => $serie['first_air_date'],
                        'vote_average' => $serie['vote_average'],
                        'vote_count' => $serie['vote_count'],
                        'popularity' => $serie['popularity'],
                        'genre_ids' => json_encode($serie['genre_ids'])
                    ]
                );
            } catch (Exception $e) {
                Log::error("Failed to save movie ID {$serie['id']} for language {$language}: " . $e->getMessage());
                throw $e;
            }
        }
    }
}
