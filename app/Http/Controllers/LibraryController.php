<?php

namespace App\Http\Controllers;

use App\Models\MediaUser;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        $items = MediaUser::where('user_id', Auth::id())->get();

        return view('library.index', compact('items'));
    }

    public function addToPlanned($id)
    {
        MediaUser::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'media_item_id' => $id,
            ],
            [
                'status' => 'planned',
            ]
        );

        return redirect('/media')->with('success', 'Item added to Planned list.');
    }
}