<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentBookingController;

Route::post('/membership-applications', [MembershipApplicationController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);




Route::middleware('auth:sanctum')->group(function () {


    Route::apiResource('membership-applications', MembershipApplicationController::class)
         ->only(['index', 'show']);
    Route::post('/membership-applications/{id}/approve', [MembershipApplicationController::class, 'approve']);
    Route::post('/membership-applications/{id}/reject', [MembershipApplicationController::class, 'reject']);


    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::apiResource('users', UserController::class)
         ->only(['index', 'show']); 

    Route::apiResource('equipment-bookings', EquipmentBookingController::class)
         ->only(['index','show','store']);

    Route::post('/equipment-bookings/{id}/approve', [EquipmentBookingController::class, 'approve']);
    Route::post('/equipment-bookings/{id}/reject', [EquipmentBookingController::class, 'reject']);
});
