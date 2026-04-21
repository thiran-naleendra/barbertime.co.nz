<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function home()     { return view('public.home'); }
    public function services() { return view('public.services'); }
    public function products() { return view('public.products'); }
    public function gallery()  { return view('public.gallery'); }
    public function contact()  { return view('public.contact'); }
    public function book()     { return view('public.book'); }
}
