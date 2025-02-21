<?php

namespace App\Console\Commands;

use App\Contracts\TmdbApiInterface;
use App\Jobs\FetchGenresFromTmdb;
use App\Jobs\FetchMoviesFromTmdb;
use App\Jobs\FetchSeriesFromTmdb;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:fetch-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch movies, series, and genres from TMDB API';

    /**
     * Execute the console command.
     */

    public function handle(TmdbApiInterface $tmdbApi): void
    {
        try {
            FetchMoviesFromTmdb::dispatch($tmdbApi);
            FetchSeriesFromTmdb::dispatch($tmdbApi);
            FetchGenresFromTmdb::dispatch($tmdbApi);

            $this->info('Jobs dispatched successfully.');

        } catch (\Exception $e) {
            $this->error('Failed to dispatch jobs: ' . $e->getMessage());
            Log::error('Failed to dispatch TMDB fetch jobs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
