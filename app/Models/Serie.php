<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = [
        'tmdb_id', 'name_en', 'name_pl', 'name_de', 'overview_en', 'overview_pl', 'overview_de',
        'first_air_date', 'vote_average', 'vote_count', 'popularity', 'genre_ids'
    ];
    protected $casts = [
        'genre_ids' => 'array',
    ];
    public function getName($language = 'en')
    {
        return $this->{"name_" . $language} ?? $this->name_en;
    }

    public function getOverview($language = 'en')
    {
        return $this->{"overview_" . $language} ?? $this->overview_en;
    }
}
