<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Http\Resources\MembershipApplicationResource;
use App\Http\Resources\UserResource;
use App\Services\MembershipService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;

class MembershipApplicationController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(MembershipService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $this->authorize('viewAny', MembershipApplication::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'You are not allowed to view membership applications.'
            ], 403);
        }

        $applications = MembershipApplication::all();
        return MembershipApplicationResource::collection($applications);
    }

    public function show($id)
    {
        $application = MembershipApplication::findOrFail($id);

        try {
            $this->authorize('view', $application);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'You are not allowed to view this application.'
            ], 403);
        }

        return new MembershipApplicationResource($application);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Personal Info
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:membership_applications,email',
            'stu_id' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',

            // Academic Background
            'qualification' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'cv_path' => 'required|string|max:255',

            // Research Interest
            'motivation' => 'required|string',
            'time_management' => 'required|string',
            'availability' => 'required|string',
        ]);

        $application = $this->service->createApplication($validated);

        return new MembershipApplicationResource($application);
    }

    public function approve($id)
    {
        $application = MembershipApplication::findOrFail($id);

        try {
            $this->authorize('approve', $application);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'You are not allowed to approve this application.'
            ], 403);
        }

        $approved = $this->service->approveApplication(
            $application,
            auth()->user()->id
        );

        return response()->json([
            'message' => 'Application approved successfully',
            'data' => [
                'application' => new MembershipApplicationResource($application),
                'member_id'   => $approved['member_id'],
                'password'    => $approved['password'], // initial password
                'user'        => new UserResource($approved['user']),
            ]
        ]);
    }

    public function reject(Request $request, $id)
    {
        $application = MembershipApplication::findOrFail($id);

        try {
            $this->authorize('reject', $application);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'You are not allowed to reject this application.'
            ], 403);
        }

        $rejected = $this->service->rejectApplication(
            $application,
            auth()->id(),
            $request->review_notes
        );

        return new MembershipApplicationResource($rejected);
    }
}
