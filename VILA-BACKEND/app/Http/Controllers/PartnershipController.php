<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partnership;

class PartnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Partnership::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('partnerships', 'public');
        }

        return Partnership::create([
            ...$validated,
            'thumbnail' => $path,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Partnership::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $partnership = Partnership::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'sometimes|required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        // Keep old thumbnail by default
        $path = $partnership->thumbnail;

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($partnership->thumbnail) {
                \Storage::disk('public')->delete($partnership->thumbnail);
            }

            $path = $request->file('thumbnail')->store('partnerships', 'public');
        }

        // Update fields
        if (isset($validated['name'])) {
            $partnership->name = $validated['name'];
        }

        $partnership->thumbnail = $path;
        $partnership->save();

        return $partnership;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partnership = Partnership::findOrFail($id);
        $partnership->delete();

        return response()->noContent();
    }
}
