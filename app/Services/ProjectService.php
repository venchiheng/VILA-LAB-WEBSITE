<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function getAllProjects()
    {
        return Project::with([
            'category',
            'members.user',
            // 'progress',
            // 'publications'
        ])->latest()->get();
    }

    public function getProjectById($id)
    {
        return Project::with([
            'category',
            'members.user',
            // 'progress',
            // 'publications'
        ])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data)
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }
}
