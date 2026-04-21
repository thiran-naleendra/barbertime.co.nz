<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderByDesc('id')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:1440'],
            'is_active' => ['nullable'],

            /**
             * ✅ Image upload (cPanel-friendly)
             * - Accepts JPG/JPEG (including some "pjpeg"), PNG, WEBP
             * - Uses mimetypes to handle "weird" JPGs from phones/apps
             * - Optional on create (set to required if you want)
             */
            'image' => ['nullable', 'image', 'mimetypes:image/jpeg,image/pjpeg,image/png,image/webp', 'max:4096'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        // ✅ store image to storage/app/public/services
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:1440'],
            'is_active' => ['nullable'],

            /**
             * ✅ Image upload (same rule as store)
             */
            'image' => ['nullable', 'image', 'mimetypes:image/jpeg,image/pjpeg,image/png,image/webp', 'max:4096'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        // ✅ replace image
        if ($request->hasFile('image')) {
            if ($service->image_path && Storage::disk('public')->exists($service->image_path)) {
                Storage::disk('public')->delete($service->image_path);
            }
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        // ✅ delete image file too
        if ($service->image_path && Storage::disk('public')->exists($service->image_path)) {
            Storage::disk('public')->delete($service->image_path);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function show(Service $service)
    {
        return redirect()->route('admin.services.edit', $service);
    }
}
