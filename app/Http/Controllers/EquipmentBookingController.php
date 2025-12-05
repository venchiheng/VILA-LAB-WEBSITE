<?php

namespace App\Http\Controllers;

use App\Models\EquipmentBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentBookingController extends Controller
{
    public function index()
    {
        return EquipmentBooking::with(['user', 'equipment'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $validated['user_id'] = Auth::id(); // Assuming authenticated user

        return EquipmentBooking::create($validated);
    }

    public function show(EquipmentBooking $equipmentBooking)
    {
        return $equipmentBooking->load(['user', 'equipment', 'notifications']);
    }

    public function update(Request $request, EquipmentBooking $equipmentBooking)
    {
        $validated = $request->validate([
            'status' => 'in:pending,approved,rejected',
            'admin_id' => 'exists:users,id',
        ]);

        $equipmentBooking->update($validated);
        return $equipmentBooking;
    }

    public function destroy(EquipmentBooking $equipmentBooking)
    {
        $equipmentBooking->delete();
        return response()->noContent();
    }
}
