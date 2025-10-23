<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        // Load all gallery items with their associated service
        return Gallery::with('service')->get();
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'before_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'after_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        // Store images
        $beforePath = $request->file('before_image')->store('galleries', 'public');
        $afterPath = $request->file('after_image')->store('galleries', 'public');

        // Save to DB
        Gallery::create([
            'service_id' => $validated['service_id'],
            'before_image' => $beforePath,
            'after_image' => $afterPath,
            'caption' => $validated['caption'] ?? null,
        ]);

        return response()->json(['message' => 'Gallery pair added successfully']);
    }
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete files from storage (if they exist)
        if ($gallery->before_image && Storage::disk('public')->exists($gallery->before_image)) {
            Storage::disk('public')->delete($gallery->before_image);
        }

        if ($gallery->after_image && Storage::disk('public')->exists($gallery->after_image)) {
            Storage::disk('public')->delete($gallery->after_image);
        }

        // Delete record from database
        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted successfully.']);
    }
}
