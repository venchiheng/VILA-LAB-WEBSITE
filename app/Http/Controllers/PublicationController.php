<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicationController extends Controller
{
    /**
     * Display a listing of publications.
     */
    public function index()
    {
        return Publication::with('project')->get();
    }

    /**
     * Store a newly created publication.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'      => 'required|exists:projects,id',
            'title'           => 'required|string|max:255',
            'authors'         => 'nullable|string'
            // 'published_date'  => 'nullable|date',
        ]);

        return Publication::create([
            ...$validated,
            'published_date' => Carbon::now('Asia/Phnom_Penh'),
        ]);
    }

    /**
     * Display the specified publication.
     */
    public function show(Publication $publication)
    {
        return $publication->load('project');
    }

    /**
     * Update the specified publication.
     */
    public function update(Request $request, Publication $publication)
    {
        $validated = $request->validate([
            'project_id'      => 'sometimes|exists:projects,id',
            'title'           => 'sometimes|string|max:255',
            'authors'         => 'nullable|string',
            'published_date'  => 'nullable|date',
        ]);

        $publication->update($validated);
        $publication->published_date = Carbon::now('Asia/Phnom_Penh');
        $publication->save();

        return $publication;
    }

    /**
     * Remove the specified publication.
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return response()->noContent();
    }
}
