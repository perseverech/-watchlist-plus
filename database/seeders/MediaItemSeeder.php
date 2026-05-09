<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaItem;

class MediaItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MediaItem::create([
            'title' => 'Inception',
            'type' => 'movie',
            'description' => 'A mind-bending thriller',
        ]);

        MediaItem::create([
            'title' => 'Breaking Bad',
            'type' => 'series',
            'description' => 'A chemistry teacher becomes a drug kingpin',
        ]);

        MediaItem::create([
            'title' => 'Interstellar',
            'type' => 'movie',
            'description' => 'Space exploration and time',
        ]);
    }
}