<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'tmdb_id', 'title_en', 'title_pl', 'title_de',
        'overview_en', 'overview_pl', 'overview_de',
        'release_date', 'vote_average', 'vote_count',
        'popularity', 'genre_ids'
    ];

    protected $casts = [
        'genre_ids' => 'array',
    ];
    public function getTitle($language = 'en')
    {
        return $this->{"title_" . $language} ?? $this->title_en;
    }

    public function getOverview($language = 'en')
    {
        return $this->{"overview_" . $language} ?? $this->overview_en;
    }
}
