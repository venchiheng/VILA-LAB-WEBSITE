<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function index()
    {
        return Publication::with('project')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'authors' => 'nullable|string',
            'published_date' => 'nullable|date',
        ]);

        return Publication::create($validated);
    }

    public function show(Publication $publication)
    {
        return $publication->load('project');
    }

    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'project_id' => 'exists:projects,id',
            'title' => 'string|max:255',
            'authors' => 'nullable|string',
            'published_date' => 'nullable|date',
        ]);

        $publication->update($validated);
        return $publication;
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();
        return response()->noContent();
    }
}
