<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('category')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:ongoing,completed,on-hold',
            'is_featured' => 'boolean',
            'banner_image' => 'nullable|string',
        ]);

        return Project::create($validated);
    }

    public function show(Project $project)
    {
        return $project->load(['category', 'publications', 'progressUpdates', 'members']);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'category_id' => 'exists:project_categories,id',
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:ongoing,completed,on-hold',
            'is_featured' => 'boolean',
            'banner_image' => 'nullable|string',
        ]);

        $project->update($validated);
        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
