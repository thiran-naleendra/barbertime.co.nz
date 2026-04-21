<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            // delete old file
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }
}
