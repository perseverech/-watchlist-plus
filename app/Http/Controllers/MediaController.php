<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;
use App\Models\MediaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MediaController extends Controller
{
    public function index()
    {
        $trending = MediaItem::latest()->get()->map(function ($item) {
            return $this->enrichWithTmdb($item);
        });

        $genres = MediaItem::whereNotNull('genre')
            ->select('genre')
            ->distinct()
            ->orderBy('genre')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->genre,
                    'name' => $item->genre,
                ];
            });

        return view('media.index', compact('trending', 'genres'));
    }

    public function search(Request $request)
    {
        $query = MediaItem::query();

        if ($request->filled('query')) {
            $query->where('title', 'like', '%' . $request->query('query') . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->query('genre'));
        }

        if ($request->filled('type')) {
            $type = $request->query('type') === 'tv'
                ? 'series'
                : $request->query('type');

            $query->where('type', $type);
        }

        $items = $query->get()->map(function ($item) {
            $item = $this->enrichWithTmdb($item);

            return [
                'id' => $item->id,
                'title' => $item->title,
                'poster' => $item->poster,
                'rating' => $item->rating,
                'type' => $item->type,
                'year' => $item->year,
            ];
        });

        return response()->json($items);
    }

    public function show($id)
    {
        $media = MediaItem::findOrFail($id);
        $media = $this->enrichWithTmdb($media);

        $reviews = $media->reviews()
            ->with('user')
            ->latest()
            ->get();

        $userStatus = null;

        if (auth()->check()) {
            $record = MediaUser::where('user_id', auth()->id())
                ->where('media_item_id', $id)
                ->first();

            if ($record) {
                $userStatus = $record->status;
            }
        }

        return view('media.show', compact('media', 'reviews', 'userStatus'));
    }

    private function enrichWithTmdb(MediaItem $item): MediaItem
    {
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = env('TMDB_BASE_URL', 'https://api.themoviedb.org/3');
        $imageUrl = env('TMDB_IMAGE_URL', 'https://image.tmdb.org/t/p/w500');

        if (!$apiKey) {
            return $item;
        }

        try {
            $mediaType = $item->type === 'series' ? 'tv' : 'movie';

            $response = Http::get($baseUrl . '/search/' . $mediaType, [
                'api_key' => $apiKey,
                'query' => $item->title,
                'language' => 'en-US',
                'page' => 1,
            ]);

            if (!$response->successful()) {
                return $item;
            }

            $result = $response->json('results.0');

            if (!$result) {
                return $item;
            }

            if (!empty($result['poster_path'])) {
                $item->poster = $imageUrl . $result['poster_path'];
            }

            if (!empty($result['vote_average'])) {
                $item->rating = round($result['vote_average'], 1);
            }

            if (!empty($result['overview'])) {
                $item->description = $result['overview'];
            }

            $date = $result['release_date'] ?? $result['first_air_date'] ?? null;

            if ($date) {
                $item->year = substr($date, 0, 4);
            }

            return $item;
        } catch (\Throwable $e) {
            return $item;
        }
    }
}