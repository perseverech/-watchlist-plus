<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'media_item_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = [
            'user_id' => auth()->id(),
            'rating' => $data['rating'],
        ];

        if (Schema::hasColumn('reviews', 'media_item_id')) {
            $review['media_item_id'] = $data['media_item_id'];
        }

        if (Schema::hasColumn('reviews', 'media_id')) {
            $review['media_id'] = $data['media_item_id'];
        }

        if (Schema::hasColumn('reviews', 'comment')) {
            $review['comment'] = $data['comment'] ?? '';
        }

        if (Schema::hasColumn('reviews', 'content')) {
            $review['content'] = $data['comment'] ?? '';
        }

        if (Schema::hasColumn('reviews', 'created_at')) {
            $review['created_at'] = now();
        }

        if (Schema::hasColumn('reviews', 'updated_at')) {
            $review['updated_at'] = now();
        }

        DB::table('reviews')->insert($review);

        return back();
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = [
            'rating' => $data['rating'],
        ];

        if (Schema::hasColumn('reviews', 'comment')) {
            $review['comment'] = $data['comment'] ?? '';
        }

        if (Schema::hasColumn('reviews', 'content')) {
            $review['content'] = $data['comment'] ?? '';
        }

        if (Schema::hasColumn('reviews', 'updated_at')) {
            $review['updated_at'] = now();
        }

        DB::table('reviews')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->update($review);

        return back();
    }

    public function destroy($id)
    {
        DB::table('reviews')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back();
    }
}