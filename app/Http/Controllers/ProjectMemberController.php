<?php

namespace App\Http\Controllers;

use App\Models\ProjectMember;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function index()
    {
        return ProjectMember::with(['project', 'user'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string',
        ]);

        return ProjectMember::create($validated);
    }

    public function destroy(ProjectMember $projectMember)
    {
        $projectMember->delete();
        return response()->noContent();
    }
}
