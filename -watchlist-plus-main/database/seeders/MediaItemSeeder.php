<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaItem;

class MediaItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Inception',
                'type' => 'movie',
                'genre' => 'Sci-Fi',
                'year' => 2010,
                'description' => 'A mind-bending thriller',
                'rating' => 8.8,
            ],
            [
                'title' => 'Breaking Bad',
                'type' => 'series',
                'genre' => 'Drama',
                'year' => 2008,
                'description' => 'A chemistry teacher becomes a drug kingpin',
                'rating' => 9.5,
            ],
            [
                'title' => 'Interstellar',
                'type' => 'movie',
                'genre' => 'Sci-Fi',
                'year' => 2014,
                'description' => 'Space exploration and time',
                'rating' => 8.7,
            ],
            [
                'title' => 'Spider-Man: Into the Spider-Verse',
                'type' => 'animation',
                'genre' => 'Animation',
                'year' => 2018,
                'description' => 'Animated multiverse superhero adventure',
                'rating' => 8.4,
            ],
            [
                'title' => 'Frozen',
                'type' => 'animation',
                'genre' => 'Family',
                'year' => 2013,
                'description' => 'Disney fantasy animation',
                'rating' => 7.4,
            ],
            [
                'title' => 'The Dark Knight',
                'type' => 'movie',
                'genre' => 'Action',
                'year' => 2008,
                'description' => 'Batman faces the Joker in Gotham City',
                'rating' => 9.0,
            ],
            [
                'title' => 'Titanic',
                'type' => 'movie',
                'genre' => 'Romance',
                'year' => 1997,
                'description' => 'A tragic love story aboard the Titanic',
                'rating' => 7.9,
            ],
            [
                'title' => 'The Conjuring',
                'type' => 'movie',
                'genre' => 'Horror',
                'year' => 2013,
                'description' => 'Paranormal investigators face a terrifying case',
                'rating' => 7.5,
            ],
            [
                'title' => 'Sherlock',
                'type' => 'series',
                'genre' => 'Mystery',
                'year' => 2010,
                'description' => 'A modern adaptation of Sherlock Holmes',
                'rating' => 9.1,
            ],
            [
                'title' => 'Avengers: Endgame',
                'type' => 'movie',
                'genre' => 'Adventure',
                'year' => 2019,
                'description' => 'The Avengers fight to restore the universe',
                'rating' => 8.4,
            ],
            [
                'title' => 'Joker',
                'type' => 'movie',
                'genre' => 'Crime',
                'year' => 2019,
                'description' => 'A psychological origin story of the Joker',
                'rating' => 8.4,
            ],
            [
                'title' => 'The Hangover',
                'type' => 'movie',
                'genre' => 'Comedy',
                'year' => 2009,
                'description' => 'A chaotic comedy about a lost bachelor party',
                'rating' => 7.7,
            ],
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'type' => 'movie',
                'genre' => 'Fantasy',
                'year' => 2001,
                'description' => 'A young wizard begins his journey at Hogwarts',
                'rating' => 7.6,
            ],
            [
                'title' => 'Saving Private Ryan',
                'type' => 'movie',
                'genre' => 'War',
                'year' => 1998,
                'description' => 'Soldiers search for a missing paratrooper during World War II',
                'rating' => 8.6,
            ],
            [
                'title' => 'Planet Earth',
                'type' => 'series',
                'genre' => 'Documentary',
                'year' => 2006,
                'description' => 'A documentary series exploring nature and wildlife',
                'rating' => 9.4,
            ],
        ];

        foreach ($items as $item) {
            MediaItem::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}