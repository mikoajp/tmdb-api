<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Genre;
use App\Contracts\TmdbApiInterface;

class FetchGenresFromTmdb implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TmdbApiInterface $tmdbApi;

    public function __construct(TmdbApiInterface $tmdbApi)
    {
        $this->tmdbApi = $tmdbApi;
    }

    public function handle(): void
    {
        $languages = ['en-US', 'pl-PL', 'de-DE'];

        foreach ($languages as $language) {
            $movieGenres = $this->tmdbApi->getMovieGenres($language);
            $tvGenres = $this->tmdbApi->getSeriesGenres($language);
            $allGenres = array_merge($movieGenres, $tvGenres);

            $this->validateDuplicates($allGenres);
            $this->saveGenres($allGenres, $language);
        }
    }

    private function validateDuplicates(array $genres): void
    {
        $duplicates = [];
        $seenIds = [];

        foreach ($genres as $genre) {
            if (in_array($genre['id'], $seenIds)) {
                $duplicates[] = $genre['id'];
            }
            $seenIds[] = $genre['id'];
        }

        if (!empty($duplicates)) {
           return;
        } else {
            echo "Brak duplikatów w gatunkach.\n";
        }
    }

    private function saveGenres(array $genres, string $language): void
    {
        $langCode = substr($language, 0, 2);

        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                ['tmdb_id' => $genre['id']],
                [
                    'name_' . $langCode => $genre['name']
                ]
            );
        }
    }
}
