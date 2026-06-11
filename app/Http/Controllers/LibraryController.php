<?php

namespace App\Http\Controllers;

use App\Models\MediaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LibraryController extends Controller
{
    public function library()
    {
        $userId = auth()->id();

        $planned = MediaUser::where('user_id', $userId)
            ->where('status', 'planned')
            ->with('mediaItem')
            ->get();

        $watched = MediaUser::where('user_id', $userId)
            ->where('status', 'watched')
            ->with('mediaItem')
            ->get();

        foreach ($planned as $record) {
            if ($record->mediaItem) {
                $record->mediaItem = $this->enrichWithTmdb($record->mediaItem);
            }
        }

        foreach ($watched as $record) {
            if ($record->mediaItem) {
                $record->mediaItem = $this->enrichWithTmdb($record->mediaItem);
            }
        }

        return view('library.index', compact('planned', 'watched'));
    }

    public function updateStatus(Request $request)
    {
        $mediaItemId = $request->input('media_item_id');
        $status = $request->input('status');

        MediaUser::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'media_item_id' => $mediaItemId,
            ],
            [
                'status' => $status,
            ]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->route('library');
    }

    public function removeFromLibrary(Request $request)
    {
        MediaUser::where('user_id', auth()->id())
            ->where('media_item_id', $request->input('media_item_id'))
            ->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->route('library');
    }

    private function enrichWithTmdb($item)
    {
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = env('TMDB_BASE_URL', 'https://api.themoviedb.org/3');
        $imageUrl = env('TMDB_IMAGE_URL', 'https://image.tmdb.org/t/p/w500');

        if (!$apiKey || !$item) {
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