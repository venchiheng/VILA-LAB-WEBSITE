<?php

namespace App\Http\Controllers;

use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    public function index()
    {
        return ProjectCategory::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return ProjectCategory::create($validated);
    }

    public function show(ProjectCategory $projectCategory)
    {
        return $projectCategory->load('projects');
    }

    public function update(Request $request, ProjectCategory $projectCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $projectCategory->update($validated);

        return $projectCategory;
    }

    public function destroy(ProjectCategory $projectCategory)
    {
        $projectCategory->delete();

        return response()->noContent();
    }
}
