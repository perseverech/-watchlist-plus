<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaItem;

class MediaItemSeeder extends Seeder
{
    public function run(): void
    {
        MediaItem::truncate();

        MediaItem::create([
            'title' => 'Inception',
            'type' => 'movie',
            'genre' => 'Sci-Fi',
            'year' => 2010,
            'description' => 'A mind-bending thriller',
            'rating' => 8.8,
        ]);

        MediaItem::create([
            'title' => 'Breaking Bad',
            'type' => 'series',
            'genre' => 'Drama',
            'year' => 2008,
            'description' => 'A chemistry teacher becomes a drug kingpin',
            'rating' => 9.5,
        ]);

        MediaItem::create([
            'title' => 'Interstellar',
            'type' => 'movie',
            'genre' => 'Sci-Fi',
            'year' => 2014,
            'description' => 'Space exploration and time',
            'rating' => 8.7,
        ]);

        MediaItem::create([
            'title' => 'Spider-Man: Into the Spider-Verse',
            'type' => 'animation',
            'genre' => 'Animation',
            'year' => 2018,
            'description' => 'Animated multiverse superhero adventure',
            'rating' => 8.4,
        ]);

        MediaItem::create([
            'title' => 'Frozen',
            'type' => 'animation',
            'genre' => 'Family',
            'year' => 2013,
            'description' => 'Disney fantasy animation',
            'rating' => 7.4,
        ]);
    }
}