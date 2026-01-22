<?php

namespace App\Http\Controllers;

use App\Models\ProjectMember;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    /**
     * List all members of a project
     * GET /projects/{projectId}/members
     */
    public function index($projectId)
    {
        $members = ProjectMember::with('user')
            ->where('project_id', $projectId)
            ->get();

        return response()->json($members);
    }

    /**
     * Add a user to a project
     * POST /projects/{projectId}/members
     */
    public function store(Request $request, $projectId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:50',
        ]);

        // Prevent duplicate membership
        $exists = ProjectMember::where('project_id', $projectId)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'User is already a member of this project',
            ], 409);
        }

        $member = ProjectMember::create([
            'project_id' => $projectId,
            'user_id' => $validated['user_id'],
            'role' => $validated['role'],
        ]);

        return response()->json($member, 201);
    }

    /**
     * Update member role
     * PUT /project-members/{id}
     */
    public function update(Request $request, $id)
    {
        $member = ProjectMember::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|string|max:50',
        ]);

        $member->update([
            'role' => $validated['role'],
        ]);

        return response()->json($member);
    }

    /**
     * Remove a user from a project
     * DELETE /project-members/{id}
     */
    public function destroy($id)
    {
        $member = ProjectMember::findOrFail($id);
        $member->delete();

        return response()->json([
            'message' => 'Member removed successfully',
        ]);
    }
}
