<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentBookingController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ContactMessageController;

Route::post('/membership-applications', [MembershipApplicationController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('membership-applications', MembershipApplicationController::class)
         ->only(['index', 'show']);
    Route::put('/membership-applications/{id}/approve', [MembershipApplicationController::class, 'approve']);
    Route::put('/membership-applications/{id}/reject', [MembershipApplicationController::class, 'reject']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);

    Route::apiResource('users', UserController::class)
         ->only(['index', 'show']); 
     
    Route::apiResource('equipment', EquipmentController::class);
    Route::apiResource('equipment-bookings', EquipmentBookingController::class)
         ->only(['index','show','store']);

    Route::put('/equipment-bookings/{id}/approve', [EquipmentBookingController::class, 'approve']);
    Route::put('/equipment-bookings/{id}/reject', [EquipmentBookingController::class, 'reject']);
    Route::put('/equipment-bookings/{id}/return', [EquipmentBookingController::class, 'return']);

});

Route::resource('contact-messages', ContactMessageController::class);
// Route::post('/membership-applications', [MembershipApplicationController::class, 'store']);