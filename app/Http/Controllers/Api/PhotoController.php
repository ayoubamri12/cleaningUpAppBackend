<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {
        return response()->json(Photo::all());
    }

    public function store(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        $path = $request->file('photo')->store('photos', 'public');
        $photo = Photo::create(['path' => $path]);
        return response()->json(Photo::all(), 201);
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
        return response()->json(Photo::all(),201);
    }
}
