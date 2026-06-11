<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaItem;

class MediaItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Inception', 'type' => 'movie', 'genre' => 'Sci-Fi', 'year' => 2010, 'description' => 'A mind-bending thriller', 'rating' => 8.8],
            ['title' => 'Interstellar', 'type' => 'movie', 'genre' => 'Sci-Fi', 'year' => 2014, 'description' => 'Space exploration and time', 'rating' => 8.7],
            ['title' => 'The Dark Knight', 'type' => 'movie', 'genre' => 'Action', 'year' => 2008, 'description' => 'Batman faces the Joker in Gotham City', 'rating' => 9.0],
            ['title' => 'The Shawshank Redemption', 'type' => 'movie', 'genre' => 'Drama', 'year' => 1994, 'description' => 'Two imprisoned men form a powerful friendship over many years', 'rating' => 9.3],
            ['title' => 'Fight Club', 'type' => 'movie', 'genre' => 'Drama', 'year' => 1999, 'description' => 'An office worker forms an underground fight club', 'rating' => 8.8],
            ['title' => 'Pulp Fiction', 'type' => 'movie', 'genre' => 'Crime', 'year' => 1994, 'description' => 'Interconnected stories of crime in Los Angeles', 'rating' => 8.9],
            ['title' => 'Forrest Gump', 'type' => 'movie', 'genre' => 'Drama', 'year' => 1994, 'description' => 'A kind man witnesses major historical events through his life', 'rating' => 8.8],
            ['title' => 'The Matrix', 'type' => 'movie', 'genre' => 'Sci-Fi', 'year' => 1999, 'description' => 'A hacker discovers the truth about simulated reality', 'rating' => 8.7],
            ['title' => 'Gladiator', 'type' => 'movie', 'genre' => 'Action', 'year' => 2000, 'description' => 'A former Roman general seeks revenge', 'rating' => 8.5],
            ['title' => 'Avatar', 'type' => 'movie', 'genre' => 'Adventure', 'year' => 2009, 'description' => 'A marine explores the alien world of Pandora', 'rating' => 7.9],
            ['title' => 'Titanic', 'type' => 'movie', 'genre' => 'Romance', 'year' => 1997, 'description' => 'A tragic love story aboard the Titanic', 'rating' => 7.9],
            ['title' => 'Oppenheimer', 'type' => 'movie', 'genre' => 'Biography', 'year' => 2023, 'description' => 'The story of J. Robert Oppenheimer and the atomic bomb', 'rating' => 8.3],
            ['title' => 'Dune', 'type' => 'movie', 'genre' => 'Sci-Fi', 'year' => 2021, 'description' => 'A noble family becomes involved in a war for a desert planet', 'rating' => 8.0],
            ['title' => 'Dune: Part Two', 'type' => 'movie', 'genre' => 'Sci-Fi', 'year' => 2024, 'description' => 'Paul Atreides continues his journey on Arrakis', 'rating' => 8.5],
            ['title' => 'Joker', 'type' => 'movie', 'genre' => 'Crime', 'year' => 2019, 'description' => 'A psychological origin story of the Joker', 'rating' => 8.4],
            ['title' => 'Whiplash', 'type' => 'movie', 'genre' => 'Drama', 'year' => 2014, 'description' => 'A young drummer is pushed by a ruthless instructor', 'rating' => 8.5],
            ['title' => 'La La Land', 'type' => 'movie', 'genre' => 'Romance', 'year' => 2016, 'description' => 'A pianist and an actress fall in love in Los Angeles', 'rating' => 8.0],
            ['title' => 'The Conjuring', 'type' => 'movie', 'genre' => 'Horror', 'year' => 2013, 'description' => 'Paranormal investigators face a terrifying case', 'rating' => 7.5],
            ['title' => 'A Quiet Place', 'type' => 'movie', 'genre' => 'Horror', 'year' => 2018, 'description' => 'A family survives in silence while hunted by sound-sensitive creatures', 'rating' => 7.5],
            ['title' => 'Get Out', 'type' => 'movie', 'genre' => 'Horror', 'year' => 2017, 'description' => 'A young man uncovers a disturbing secret during a family visit', 'rating' => 7.8],
            ['title' => 'The Hangover', 'type' => 'movie', 'genre' => 'Comedy', 'year' => 2009, 'description' => 'A chaotic comedy about a lost bachelor party', 'rating' => 7.7],
            ['title' => 'Harry Potter and the Sorcerer\'s Stone', 'type' => 'movie', 'genre' => 'Fantasy', 'year' => 2001, 'description' => 'A young wizard begins his journey at Hogwarts', 'rating' => 7.6],
            ['title' => 'The Lord of the Rings: The Fellowship of the Ring', 'type' => 'movie', 'genre' => 'Fantasy', 'year' => 2001, 'description' => 'A fellowship begins a journey to destroy the One Ring', 'rating' => 8.9],
            ['title' => 'Saving Private Ryan', 'type' => 'movie', 'genre' => 'War', 'year' => 1998, 'description' => 'Soldiers search for a missing paratrooper during World War II', 'rating' => 8.6],
            ['title' => 'Ford v Ferrari', 'type' => 'movie', 'genre' => 'Sport', 'year' => 2019, 'description' => 'A designer and driver build a race car to challenge Ferrari', 'rating' => 8.1],
            ['title' => 'Se7en', 'type' => 'movie', 'genre' => 'Thriller', 'year' => 1995, 'description' => 'Two detectives hunt a serial killer using the seven deadly sins', 'rating' => 8.6],
            ['title' => 'The Good, the Bad and the Ugly', 'type' => 'movie', 'genre' => 'Western', 'year' => 1966, 'description' => 'Three gunslingers search for buried gold', 'rating' => 8.8],
            ['title' => 'Spider-Man: Into the Spider-Verse', 'type' => 'animation', 'genre' => 'Animation', 'year' => 2018, 'description' => 'Animated multiverse superhero adventure', 'rating' => 8.4],
            ['title' => 'Frozen', 'type' => 'animation', 'genre' => 'Family', 'year' => 2013, 'description' => 'Disney fantasy animation', 'rating' => 7.4],
            ['title' => 'Toy Story', 'type' => 'animation', 'genre' => 'Animation', 'year' => 1995, 'description' => 'Toys come to life when humans are not around', 'rating' => 8.3],
            ['title' => 'Coco', 'type' => 'animation', 'genre' => 'Family', 'year' => 2017, 'description' => 'A boy travels to the Land of the Dead to discover his family history', 'rating' => 8.4],
            ['title' => 'Inside Out', 'type' => 'animation', 'genre' => 'Family', 'year' => 2015, 'description' => 'Emotions guide a young girl through a major life change', 'rating' => 8.1],
            ['title' => 'Zootopia', 'type' => 'animation', 'genre' => 'Animation', 'year' => 2016, 'description' => 'A rabbit police officer investigates a mystery in a city of animals', 'rating' => 8.0],
            ['title' => 'Moana', 'type' => 'animation', 'genre' => 'Adventure', 'year' => 2016, 'description' => 'A young girl sails across the ocean to save her island', 'rating' => 7.6],

            ['title' => 'Breaking Bad', 'type' => 'series', 'genre' => 'Drama', 'year' => 2008, 'description' => 'A chemistry teacher becomes a drug kingpin', 'rating' => 9.5],
            ['title' => 'Better Call Saul', 'type' => 'series', 'genre' => 'Crime', 'year' => 2015, 'description' => 'The transformation of Jimmy McGill into Saul Goodman', 'rating' => 9.0],
            ['title' => 'Game of Thrones', 'type' => 'series', 'genre' => 'Fantasy', 'year' => 2011, 'description' => 'Noble families fight for control of the Iron Throne', 'rating' => 9.2],
            ['title' => 'House of the Dragon', 'type' => 'series', 'genre' => 'Fantasy', 'year' => 2022, 'description' => 'The history of House Targaryen before Game of Thrones', 'rating' => 8.4],
            ['title' => 'Stranger Things', 'type' => 'series', 'genre' => 'Sci-Fi', 'year' => 2016, 'description' => 'Children uncover supernatural events in a small town', 'rating' => 8.7],
            ['title' => 'Dark', 'type' => 'series', 'genre' => 'Sci-Fi', 'year' => 2017, 'description' => 'A German town is affected by time travel and family secrets', 'rating' => 8.7],
            ['title' => 'Sherlock', 'type' => 'series', 'genre' => 'Mystery', 'year' => 2010, 'description' => 'A modern adaptation of Sherlock Holmes', 'rating' => 9.1],
            ['title' => 'Friends', 'type' => 'series', 'genre' => 'Comedy', 'year' => 1994, 'description' => 'Six friends navigate life and relationships in New York', 'rating' => 8.9],
            ['title' => 'The Office', 'type' => 'series', 'genre' => 'Comedy', 'year' => 2005, 'description' => 'A mockumentary about office employees and their daily work life', 'rating' => 9.0],
            ['title' => 'Peaky Blinders', 'type' => 'series', 'genre' => 'Crime', 'year' => 2013, 'description' => 'A gangster family builds power in post-war Birmingham', 'rating' => 8.8],
            ['title' => 'The Last of Us', 'type' => 'series', 'genre' => 'Drama', 'year' => 2023, 'description' => 'A smuggler escorts a girl across a post-apocalyptic America', 'rating' => 8.7],
            ['title' => 'Wednesday', 'type' => 'series', 'genre' => 'Mystery', 'year' => 2022, 'description' => 'Wednesday Addams investigates mysteries at Nevermore Academy', 'rating' => 8.1],
            ['title' => 'Black Mirror', 'type' => 'series', 'genre' => 'Sci-Fi', 'year' => 2011, 'description' => 'Anthology stories about technology and society', 'rating' => 8.7],
            ['title' => 'Chernobyl', 'type' => 'series', 'genre' => 'History', 'year' => 2019, 'description' => 'A dramatization of the Chernobyl nuclear disaster', 'rating' => 9.3],
            ['title' => 'The Boys', 'type' => 'series', 'genre' => 'Action', 'year' => 2019, 'description' => 'A group fights corrupt superheroes', 'rating' => 8.7],
            ['title' => 'Planet Earth', 'type' => 'series', 'genre' => 'Documentary', 'year' => 2006, 'description' => 'A documentary series exploring nature and wildlife', 'rating' => 9.4],
        ];

        foreach ($items as $item) {
            MediaItem::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}