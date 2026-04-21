<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::orderBy('sort_order')->orderByDesc('id')->paginate(12);
        return view('admin.barbers.index', compact('barbers'));
    }

    public function create()
    {
        return view('admin.barbers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $barber = new Barber();
        $barber->name = $data['name'];
        $barber->is_active = (bool)($data['is_active'] ?? true);
        $barber->sort_order = (int)($data['sort_order'] ?? 0);

        if ($request->hasFile('image')) {
            $barber->image_path = $request->file('image')->store('barbers', 'public');
        }

        $barber->save();

        return redirect()->route('admin.barbers.index')->with('success', 'Barber added.');
    }

    public function edit(Barber $barber)
    {
        return view('admin.barbers.edit', compact('barber'));
    }

    public function update(Request $request, Barber $barber)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $barber->name = $data['name'];
        $barber->is_active = (bool)($data['is_active'] ?? $barber->is_active);
        $barber->sort_order = (int)($data['sort_order'] ?? $barber->sort_order);

        if ($request->hasFile('image')) {
            if ($barber->image_path && Storage::disk('public')->exists($barber->image_path)) {
                Storage::disk('public')->delete($barber->image_path);
            }
            $barber->image_path = $request->file('image')->store('barbers', 'public');
        }

        $barber->save();

        return redirect()->route('admin.barbers.index')->with('success', 'Barber updated.');
    }

    public function destroy(Barber $barber)
    {
        if ($barber->image_path && Storage::disk('public')->exists($barber->image_path)) {
            Storage::disk('public')->delete($barber->image_path);
        }
        $barber->delete();

        return redirect()->route('admin.barbers.index')->with('success', 'Barber deleted.');
    }
}
