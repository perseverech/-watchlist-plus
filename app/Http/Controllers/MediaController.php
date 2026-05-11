<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaItem;
use App\Models\Genre;
use App\Models\Review;
use App\Models\MediaUser;

class MediaController extends Controller
{
    /**
     * GET /
     * Homepage — renders media/index.blade.php
     */
    public function index()
    {
        // ⚠️ DEPENDS ON AL'ZHANA: getTrending() on MediaItem model
        $trending = MediaItem::getTrending();

        // ⚠️ DEPENDS ON AL'ZHANA: Genre model
        $genres = Genre::all();

        return view('media.index', compact('trending', 'genres'));
    }

    /**
     * GET /media/{id}
     * Detail page — renders media/show.blade.php
     */
    public function show($id)
    {
        // ⚠️ DEPENDS ON AL'ZHANA: getById() fetching from external API + DB
        $media = MediaItem::getById($id);

        if (!$media) {
            abort(404);
        }

        // ⚠️ DEPENDS ON AL'ZHANA: Review model with user() relationship
        $reviews = Review::with('user')
            ->where('media_id', $id)
            ->latest()
            ->get();

        // Check current user's library status
        $userStatus = null;
        if (auth()->check()) {
            $entry = MediaUser::where('user_id', auth()->id())
                ->where('media_id', $id)
                ->first();
            $userStatus = $entry?->status;
        }

        return view('media.show', compact('media', 'reviews', 'userStatus'));
    }

    /**
     * GET /search
     * AJAX endpoint — called by search.js
     */
    public function search(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        }

        $query = $request->input('query', '');
        $genre = $request->input('genre', '');
        $type  = $request->input('type', '');

        // ⚠️ DEPENDS ON AL'ZHANA: search() on MediaItem model
        $results = MediaItem::search($query, $genre, $type);

        return response()->json($results);
    }
}
