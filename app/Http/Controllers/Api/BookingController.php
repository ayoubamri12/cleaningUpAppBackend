<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
class BookingController extends Controller
{
     public function index()
    {
        return Booking::latest()->get();
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
            'service' => 'required|string|max:255',
            'date'    => 'required|date',
            'time'    => 'nullable',
            'message' => 'nullable|string',
        ]);

        Booking::create($validated);

        return response()->json(['message' => 'Booking created successfully']);
    }

   
}

