<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ProgressProgressController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContactResponseController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentBookingController;
use App\Http\Controllers\NotificationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public Routes
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/project-categories', [ProjectCategoryController::class, 'index']);
Route::get('/publications', [PublicationController::class, 'index']);
Route::get('/equipment', [EquipmentController::class, 'index']);
Route::post('/contact-messages', [ContactMessageController::class, 'store']);

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    
    // User Profile
    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::post('/profile', [UserProfileController::class, 'update']);

    // Admin / Management Routes
    // Note: You might want to add 'can:admin' middleware here for stricter control
    
    // Projects & Content
    Route::apiResource('project-categories', ProjectCategoryController::class)->except(['index']);
    Route::apiResource('projects', ProjectController::class)->except(['index', 'show']);
    Route::apiResource('publications', PublicationController::class)->except(['index']);
    Route::apiResource('progress-updates', ProgressProgressController::class);
    Route::apiResource('project-members', ProjectMemberController::class);

    // Contact Messages (Admin)
    Route::get('/contact-messages', [ContactMessageController::class, 'index']);
    Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show']);
    Route::put('/contact-messages/{contactMessage}', [ContactMessageController::class, 'update']);
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy']);
    Route::post('/contact-responses', [ContactResponseController::class, 'store']);

    // Equipment Management
    Route::apiResource('equipment', EquipmentController::class)->except(['index', 'show']);
    
    // Bookings
    Route::apiResource('equipment-bookings', EquipmentBookingController::class);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);

    // Users (Admin)
    Route::apiResource('users', UserController::class);
    Route::put('/users/{user}/role', [UserController::class, 'updateRole']);
});
