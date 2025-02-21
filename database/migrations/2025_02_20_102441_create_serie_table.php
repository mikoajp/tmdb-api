<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->integer('tmdb_id')->unique();
            $table->string('name_en');
            $table->string('name_pl')->nullable();
            $table->string('name_de')->nullable();
            $table->text('overview_en');
            $table->text('overview_pl')->nullable();
            $table->text('overview_de')->nullable();
            $table->date('first_air_date');
            $table->float('vote_average', 8, 2)->nullable();
            $table->integer('vote_count')->nullable();
            $table->float('popularity')->nullable();
            $table->json('genre_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
