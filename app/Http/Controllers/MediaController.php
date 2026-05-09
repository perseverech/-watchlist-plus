<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = MediaItem::all();

        return view('media.index', compact('mediaItems'));
    }
}