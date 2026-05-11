<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaUser;

class LibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET /library
     * Renders library/index.blade.php
     */
    public function library()
    {
        $userId = auth()->id();

        // ⚠️ DEPENDS ON AL'ZHANA: MediaUser->mediaItem relationship
        $planned = MediaUser::with('mediaItem')
            ->where('user_id', $userId)
            ->where('status', 'planned')
            ->latest()
            ->get()
            ->map(fn($mu) => $mu->mediaItem);

        $watched = MediaUser::with('mediaItem')
            ->where('user_id', $userId)
            ->where('status', 'watched')
            ->latest()
            ->get()
            ->map(fn($mu) => $mu->mediaItem);

        return view('library.index', compact('planned', 'watched'));
    }

    /**
     * POST /library/update
     * AJAX endpoint
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'media_id' => 'required|integer',
            'status'   => 'required|in:planned,watched',
        ]);

        $entry = MediaUser::updateOrCreate(
            ['user_id'  => auth()->id(), 'media_id' => $request->media_id],
            ['status'   => $request->status]
        );

        return response()->json(['success' => true, 'status' => $entry->status]);
    }

    /**
     * POST /library/remove
     * AJAX endpoint
     */
    public function removeFromLibrary(Request $request)
    {
        $request->validate(['media_id' => 'required|integer']);

        MediaUser::where('user_id', auth()->id())
            ->where('media_id', $request->media_id)
            ->delete();

        return response()->json(['success' => true]);
    }
}
