<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::setValue('salon_name', config('app.name'));
        Setting::setValue('contact_phone', '+64');
        Setting::setValue('contact_email', 'info@example.com');
        Setting::setValue('contact_address', 'Auckland, New Zealand');

        // Put your Google Maps embed iframe code here later
        Setting::setValue('map_embed', '');
    }
}
