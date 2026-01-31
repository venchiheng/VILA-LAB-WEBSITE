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
        // Validate inputs including file
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:membership_applications,email',
            'stu_id' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',

            'faculty' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            // 'cv_path' => 'required|string|max:255',
            'cv_path' => 'required|file|mimes:pdf,doc,docx|max:2048',


            'motivation' => 'required|string',
            'time_management' => 'required|string',
            'availability' => 'required|string',
        ]);

        // Handle CV file upload
        if ($request->hasFile('cv_path')) {
            $file = $request->file('cv_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // unique file name
            $path = $file->storeAs('cvs', $filename, 'public'); // storage/app/public/cvs
            $validated['cv_path'] = $path; // pass path to service
        }

        // Create the application
        $application = $this->service->createApplication($validated);

        return new MembershipApplicationResource($application);
    }
    // public function store(Request $request)
    // {
    //     // Validate input
    //     $request->validate([
    //         'full_name'       => 'required|string|max:255',
    //         'gender'          => 'required|in:male,female,other',
    //         'email'           => 'required|email|unique:membership_applications,email',
    //         'stu_id'          => 'required|string|max:50',
    //         'phone_number'    => 'required|string|max:20',
    //         'faculty'         => 'required|string|max:255',
    //         'year'            => 'required|string|max:10',
    //         'cv_path'         => 'required|file|mimes:pdf,doc,docx|max:2048',
    //         'motivation'      => 'required|string',
    //         'time_management' => 'required|string',
    //         'availability'    => 'required|string',
    //     ]);

    //     // Prepare application
    //     $application = new MembershipApplication;
    //     $application->full_name       = $request->full_name;
    //     $application->gender          = $request->gender;
    //     $application->email           = $request->email;
    //     $application->stu_id          = $request->stu_id;
    //     $application->phone_number    = $request->phone_number;
    //     $application->faculty         = $request->faculty;
    //     $application->year            = $request->year;
    //     $application->motivation      = $request->motivation;
    //     $application->time_management = $request->time_management;
    //     $application->availability    = $request->availability;
    //     $application->status          = 'pending';

    //     // Handle CV upload
    //     if ($request->hasFile('cv_path')) {
    //         $originalName = $request->file('cv_path')->getClientOriginalName();
    //         $storedPath   = $request->file('cv_path')->storeAs(
    //             'cvs',                    // folder in storage/app/public
    //             uniqid() . '_' . $originalName,
    //             'public'
    //         );

    //         $application->cv_path = $storedPath;
    //         $application->original_cv_name = $originalName; // optional: store original filename
    //     }

    //     $application->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Membership application submitted successfully!',
    //         'data' => $application
    //     ], 201);
    // }

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
