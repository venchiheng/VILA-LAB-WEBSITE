<?php

namespace App\Http\Controllers;

use App\Models\ProgressProgress;
use Illuminate\Http\Request;

class ProgressProgressController extends Controller
{
    public function index()
    {
        return ProgressProgress::with('project')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        return ProgressProgress::create($validated);
    }

    public function show(ProgressProgress $progressProgress)
    {
        return $progressProgress->load('project');
    }

    public function update(Request $request, ProgressProgress $progressProgress)
    {
        $validated = $request->validate([
            'project_id' => 'exists:projects,id',
            'title' => 'string|max:255',
            'description' => 'nullable|string',
        ]);

        $progressProgress->update($validated);
        return $progressProgress;
    }

    public function destroy(ProgressProgress $progressProgress)
    {
        $progressProgress->delete();
        return response()->noContent();
    }
}
