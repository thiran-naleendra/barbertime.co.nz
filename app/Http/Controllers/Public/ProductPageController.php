<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductPageController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('public.products', compact('products'));
    }
}
