<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Achievement::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('achievements', 'public');
        }

        return Achievement::create([
            ...$validated,
            'thumbnail' => $path,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Achievement::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $achievement = Achievement::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);

        $path = $achievement->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('achievements', 'public');
        }

        $achievement->update([
            ...$validated,
            'thumbnail' => $path,
        ]);

        return $achievement;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();

        return response()->noContent();
    }
}
