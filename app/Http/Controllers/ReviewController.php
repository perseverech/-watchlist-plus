<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $mediaItemId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'media_item_id' => $mediaItemId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect('/media')->with('success', 'Review added successfully.');
    }
}