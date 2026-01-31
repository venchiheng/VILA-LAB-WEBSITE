<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->getAllProjects();
        return ProjectResource::collection($projects);
    }

    public function show($id)
    {
        $project = $this->projectService->getProjectById($id);
        return new ProjectResource($project);
    }

    public function store(Request $request)
    {
        // Validate the request
        $data = $request->validate([
            'category_id'  => 'required|exists:project_categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'required|in:ongoing,completed,on-hold',
            'is_featured'  => 'boolean',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('projects', 'public');
            $data['banner_image'] = $path; // add the saved file path to $data
        }

        // Create the project
        $project = $this->projectService->create($data);

        return new ProjectResource($project);
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'category_id'  => 'sometimes|exists:project_categories,id',
            'title'        => 'sometimes|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'in:ongoing,completed,on-hold',
            'is_featured'  => 'boolean',
            'banner_image' => 'nullable|string',
        ]);

        $project = $this->projectService->update($project, $data);
        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $this->projectService->delete($project);
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
