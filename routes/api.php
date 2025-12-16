<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipApplicationController;

// Public route: submit a membership application
Route::post('/membership-applications', [MembershipApplicationController::class, 'store']);

// Protected routes: only for authenticated users (admin)
Route::middleware(['auth.basic'])->group(function () {
    
    // List all applications and view a single application
    Route::apiResource('membership-applications', MembershipApplicationController::class)
         ->only(['index', 'show']);

    // Approve or reject a membership application
    Route::post('/membership-applications/{id}/approve', [MembershipApplicationController::class, 'approve']);
    Route::post('/membership-applications/{id}/reject', [MembershipApplicationController::class, 'reject']);
});
