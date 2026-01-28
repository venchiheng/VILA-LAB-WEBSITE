<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentBookingResource;
use App\Models\EquipmentBooking;
use App\Services\EquipmentBookingService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EquipmentBookingController extends Controller
{
    use AuthorizesRequests;

    
    public function index()
    {
        $this->authorize('viewAny', EquipmentBooking::class);

        $query = EquipmentBooking::with('equipment')->latest();

        if (auth()->user()->role === 'member') {
            $query->where('member_id', auth()->id());
        }

        return EquipmentBookingResource::collection($query->get());
    }

    
    public function show($id)
    {
        $booking = EquipmentBooking::with('equipment')->findOrFail($id);

        $this->authorize('view', $booking);

        return new EquipmentBookingResource($booking);
    }

   
    public function store(Request $request, EquipmentBookingService $service)
    {
        $this->authorize('create', EquipmentBooking::class);

        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'booking_date' => 'required|date',
            'return_date'  => 'required|date',
            'quantity'     => 'nullable|integer|min:1',
            'purpose'      => 'nullable|string',
        ]);

        $validated['member_id'] = auth()->id();
        $validated['full_name'] = auth()->user()->name;

        $booking = $service->create($validated);

        return new EquipmentBookingResource($booking);
    }

    
    public function approve($id, EquipmentBookingService $service)
    {
        $booking = EquipmentBooking::findOrFail($id);

        $this->authorize('approve', EquipmentBooking::class);

        $booking = $service->approve($booking, auth()->id());

        return new EquipmentBookingResource($booking);
    }

 
    public function reject($id, EquipmentBookingService $service)
    {
        $booking = EquipmentBooking::findOrFail($id);

        $this->authorize('reject', EquipmentBooking::class);

        $booking = $service->reject($booking, auth()->id());

        return new EquipmentBookingResource($booking);
    }

    
    public function return($id, EquipmentBookingService $service)
    {
        $booking = EquipmentBooking::findOrFail($id);

        $this->authorize('return', $booking);

        $booking = $service->return($booking);

        return new EquipmentBookingResource($booking);
    }
}
