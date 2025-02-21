<?php

namespace App\Contracts;

interface TmdbApiInterface
{
    public function getMovies(string $language, int $page = 1): array;
    public function getSeries(string $language, int $page = 1): array;
    public function getMovieGenres(string $language): array;
    public function getSeriesGenres(string $language): array;
}
