<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'salon_name' => Setting::getValue('salon_name'),
            'contact_phone' => Setting::getValue('contact_phone'),
            'contact_email' => Setting::getValue('contact_email'),
            'contact_address' => Setting::getValue('contact_address'),
            'map_embed' => Setting::getValue('map_embed'),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'salon_name' => ['nullable','string','max:255'],
            'contact_phone' => ['nullable','string','max:50'],
            'contact_email' => ['nullable','email','max:255'],
            'contact_address' => ['nullable','string','max:500'],
            'map_embed' => ['nullable','string','max:5000'],
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully.');
    }
}
