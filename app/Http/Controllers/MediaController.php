<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;
use App\Models\MediaUser;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $trending = MediaItem::latest()->get();

        $genres = MediaItem::whereNotNull('genre')
            ->select('genre')
            ->distinct()
            ->orderBy('genre')
            ->get()
            ->map(function ($item) {
                return (object)[
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
            return [
                'id' => $item->id,
                'title' => $item->title,
                'poster' => $item->poster,
                'rating' => round($item->reviews->avg('rating') ?? 0, 1),
                'type' => $item->type,
                'year' => $item->year,
            ];
        });

        return response()->json($items);
    }

    public function show($id)
    {
        $media = MediaItem::findOrFail($id);

        $reviews = $media->reviews()->latest()->get();

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
}