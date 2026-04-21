<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;

class GalleryPageController extends Controller
{
    public function index()
    {
        $images = GalleryImage::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('public.gallery', compact('images'));
    }
}
