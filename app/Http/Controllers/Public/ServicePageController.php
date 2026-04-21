<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServicePageController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('public.services', compact('services'));
    }
}
