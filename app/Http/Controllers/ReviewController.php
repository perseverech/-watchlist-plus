<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * POST /reviews
     * AJAX endpoint
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'media_id' => 'required|integer',
            'rating'   => 'required|integer|min:1|max:10',
            'content'  => 'required|string|min:10|max:1000',
        ]);

        // ⚠️ DEPENDS ON AL'ZHANA: Review model
        $review = Review::create([
            'user_id'  => auth()->id(),
            'media_id' => $data['media_id'],
            'rating'   => $data['rating'],
            'content'  => $data['content'],
        ]);

        $review->load('user');

        return response()->json($review, 201);
    }

    /**
     * PUT /reviews/{id}
     * AJAX endpoint
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:10',
            'content' => 'required|string|min:10|max:1000',
        ]);

        $review = Review::findOrFail($id);

        if ($review->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $review->update($data);

        return response()->json($review);
    }

    /**
     * DELETE /reviews/{id}
     * AJAX endpoint
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // ⚠️ DEPENDS ON AL'ZHANA: Role checks
        $isOwner     = $review->user_id === auth()->id();
        $isModerator = in_array(
            auth()->user()->role->name ?? '',
            ['moderator', 'admin']
        );

        if (!$isOwner && !$isModerator) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json(['success' => true]);
    }
}
