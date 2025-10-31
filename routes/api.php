<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\InclusionController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::get('/sanctum/csrf-cookie', function (Request $request) {
//     return response('')->cookie('XSRF-TOKEN', $request->session()->token());
// })->middleware('web');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/delete/{service}', [ServiceController::class, 'destroy']);
    Route::resource('offers', OfferController::class)->only([
        'store',
        'update',
        'index',
        'destroy'
    ]);
    Route::resource('gallery', GalleryController::class)->only([
        'store',
        'destroy'
    ]);

    Route::post('/settings', [SettingsController::class, 'update']);
    Route::get('/bookings', [BookingController::class, 'index']);

    Route::post('/user/update', [AuthenticatedSessionController::class, 'updateUser']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::post('/partners', [PartnerController::class, 'store']);
    Route::delete('/partners/{partner}', [PartnerController::class, 'destroy']);

    Route::post('/prices', [PriceController::class, 'store']);
    Route::put('/prices/{id}', [PriceController::class, 'update']);
    Route::delete('/prices/{id}', [PriceController::class, 'destroy']);

    Route::get('/inclusions', [InclusionController::class, 'index']);
    Route::post('/inclusions', [InclusionController::class, 'store']);
    Route::put('/inclusions/{id}', [InclusionController::class, 'update']);
    Route::delete('/inclusions/{id}', [InclusionController::class, 'destroy']);
});

Route::middleware(['web'])->group(function () {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/activeoffers', [OfferController::class, 'activeOffers']);
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::get('/setting', [SettingsController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/partners', [PartnerController::class, 'index']);
    Route::get('/prices', [PriceController::class, 'index']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');

    // Handles the POST request for user login. Uses the AuthenticatedSessionController.
});
// Protected route to destroy the session (logout).
