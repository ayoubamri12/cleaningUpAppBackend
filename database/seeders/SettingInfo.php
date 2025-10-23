<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingInfo extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $settings = [
            ['key' => 'phone', 'value' => '+212600000000'],
            ['key' => 'email', 'value' => 'info@mydomain.com'],
            ['key' => 'address', 'value' => 'City, Country'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/'],
            ['key' => 'linkedin', 'value' => 'https://linkedin.com/'],
            ['key' => 'logo', 'value' => '/images/logo.png'],
            ['key' => 'favicon', 'value' => '/images/favicon.ico'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
