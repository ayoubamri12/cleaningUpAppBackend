<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return response()->json($settings);
    }

    // Get single setting

    // Update a setting (admin)
  public function update(Request $request)
{
    // Debug check
    // dd($request->all());

    // Update non-file settings
    foreach ($request->except(['logo', 'favicon','teampic','demovid']) as $key => $value) {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    // Handle files
    foreach (['logo', 'favicon','teampic','demovid'] as $fileKey) {
        if ($request->hasFile($fileKey)) {

            // Find old file
            $existing = Setting::where('key', $fileKey)->first();

            if ($existing && $existing->value && Storage::disk('public')->exists($existing->value)) {
                Storage::disk('public')->delete($existing->value);
            }

            // Upload new file
            $path = $request->file($fileKey)->store('settings', 'public');

            Setting::updateOrCreate(
                ['key' => $fileKey],
                ['value' => $path]
            );
        }
    }

    return response()->json(['message' => 'Settings updated successfully']);
}


}
