<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class ContactPageController extends Controller
{
    public function index()
    {
        $contact = [
            'salon_name' => Setting::getValue('salon_name', config('app.name')),
            'phone' => Setting::getValue('contact_phone', ''),
            'email' => Setting::getValue('contact_email', ''),
            'address' => Setting::getValue('contact_address', ''),
            'map_embed' => Setting::getValue('map_embed', ''),
        ];

        return view('public.contact', compact('contact'));
    }
}
