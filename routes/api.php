<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SupportController;

Route::get('connection-test', function() {
    return response()->json(['status' => 'success', 'message' => 'Backend is working!']);
});

Route::get('support', [SupportController::class, 'index']);
Route::get('cms/{slug}', [App\Http\Controllers\Api\CmsController::class, 'getPage']);
Route::get('cms/{slug}/download', [App\Http\Controllers\Api\CmsController::class, 'downloadPdf']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('send-login-otp', [AuthController::class, 'sendLoginOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);

        // Notification Routes
        Route::get('notifications', [\App\Http\Controllers\Api\NotificationController::class, 'index']);
        Route::post('notifications/{id}/read', [\App\Http\Controllers\Api\NotificationController::class, 'markAsRead']);
        Route::post('notifications/read-all', [\App\Http\Controllers\Api\NotificationController::class, 'markAllAsRead']);

        // Quote Routes
        Route::get('quotes', [\App\Http\Controllers\Api\QuoteController::class, 'index']);
        Route::post('quotes/{id}/respond', [\App\Http\Controllers\Api\QuoteController::class, 'respond']);
        Route::get('quotes/{id}/download', [\App\Http\Controllers\Api\QuoteController::class, 'download']);

        // Digital Locker Routes
        Route::get('locker', [\App\Http\Controllers\Api\LockerController::class, 'index']);
        Route::post('locker/upload', [\App\Http\Controllers\Api\LockerController::class, 'upload']);

        // Service Request Routes
        Route::get('services', [\App\Http\Controllers\Api\ServiceRequestController::class, 'index']);
        Route::post('services/book', [\App\Http\Controllers\Api\ServiceRequestController::class, 'store']);

        // Enquiry Routes
        Route::get('enquiries', [\App\Http\Controllers\Api\EnquiryController::class, 'index']);
        Route::post('enquiries/submit', [\App\Http\Controllers\Api\EnquiryController::class, 'store']);
    });
});
