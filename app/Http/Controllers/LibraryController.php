<?php

namespace App\Http\Controllers;

use App\Models\MediaUser;
use Illuminate\Http\Request;

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
}