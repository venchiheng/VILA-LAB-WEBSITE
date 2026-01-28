<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentBookingController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\PartnershipController;

Route::post('/membership-applications', [MembershipApplicationController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('project-categories', ProjectCategoryController::class)
    ->only(['index', 'store']);

Route::get('/projects/{projectId}/members', [ProjectMemberController::class, 'index']);
Route::post('/projects/{projectId}/members', [ProjectMemberController::class, 'store']);

Route::put('/project-members/{id}', [ProjectMemberController::class, 'update']);
Route::delete('/project-members/{id}', [ProjectMemberController::class, 'destroy']);
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
Route::resource('/publications', PublicationController::class);
Route::resource('/achievements', AchievementController::class);
Route::resource('/partnerships', PartnershipController::class);