<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        return Equipment::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'availability' => 'in:available,unavailable,maintenance',
        ]);

        return Equipment::create($validated);
    }

    public function show(Equipment $equipment)
    {
        return $equipment->load('bookings');
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'availability' => 'in:available,unavailable,maintenance',
        ]);

        $equipment->update($validated);
        return $equipment;
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return response()->noContent();
    }
}
