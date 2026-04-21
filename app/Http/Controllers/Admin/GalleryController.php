<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::orderBy('sort_order')->orderByDesc('id')->paginate(12);
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'sort_order' => ['nullable','integer','min:0','max:100000'],
            'image' => ['required','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $data['image_path'] = $request->file('image')->store('gallery', 'public');

        GalleryImage::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image added.');
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', ['image' => $gallery]);
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'sort_order' => ['nullable','integer','min:0','max:100000'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image_path);
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image updated.');
    }

    public function destroy(GalleryImage $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image deleted.');
    }

    public function show(GalleryImage $gallery)
    {
        return redirect()->route('admin.gallery.edit', $gallery);
    }
}
