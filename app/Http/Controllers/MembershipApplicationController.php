<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Http\Resources\MembershipApplicationResource;
use App\Services\MembershipService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

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
    $this->authorize('viewAny', MembershipApplication::class);

    $applications = MembershipApplication::all();
    return MembershipApplicationResource::collection($applications);
    }



    public function show($id)
    {
    $application = MembershipApplication::findOrFail($id);
    $this->authorize('view', $application);

    return new MembershipApplicationResource($application);
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:membership_applications,email',
            'cv_path' => 'required|string',
            'google_form_response_url' => 'nullable|string',
        ]);

        $application = $this->service->createApplication($validated);

        return new MembershipApplicationResource($application);
    }


public function approve($id)
{
    $application = MembershipApplication::findOrFail($id);
    $this->authorize('approve', $application);

    $approved = $this->service->approveApplication(
        $application,
        auth()->id()
    );

    $user = User::where('email', $approved->email)->first();

    return response()->json([
        'message' => 'Application approved successfully',
        'data' => [
            'application' => new MembershipApplicationResource($approved),
            'member_code' => $user?->member_code,
            'user_id' => $user?->id,
        ]
    ]);
}

    

    public function reject(Request $request, $id)
    {
        $application = MembershipApplication::findOrFail($id);
        $this->authorize('reject', $application);

        $rejected = $this->service->rejectApplication(
            $application,
            auth()->id(),
            $request->review_notes
        );

          return new MembershipApplicationResource($rejected);
    }


}
