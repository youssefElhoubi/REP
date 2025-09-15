<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/user', function (Request $request) {
    return $request->user();
    
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

// Protected routes
Route::middleware(['auth:api'])->group(function () {
    Route::get('me', [AuthController::class,'me']);
    Route::post('logout', [AuthController::class,'logout']);
});
Route::middleware(['auth:api','role:owner'])->group(function () {
    Route::post('properties', [PropertyController::class, 'store']);
});
Route::apiResource('properties', PropertyController::class);
// Send verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!']);
})->middleware('auth:api');

// Handle email verification
Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified!']);
})->middleware(['auth:api', 'signed'])->name('verification.verify');
Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Welcome to dashboard']);
    });
});
