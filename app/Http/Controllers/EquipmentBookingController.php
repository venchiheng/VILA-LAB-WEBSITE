<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentBooking;
use App\Http\Resources\EquipmentBookingResource;
use App\Services\EquipmentBookingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EquipmentBookingController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(EquipmentBookingService $service)
    {
        $this->service = $service;
    }

    
    public function index()
    {
        $this->authorize('viewAny', EquipmentBooking::class);

        $bookings = EquipmentBooking::all();
        return EquipmentBookingResource::collection($bookings);
    }

   
    public function show($id)
    {
        $booking = EquipmentBooking::findOrFail($id);
        $this->authorize('view', $booking);

        return new EquipmentBookingResource($booking);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'    => 'required|string|max:20',
            'full_name'    => 'required|string|max:255',
            'purpose'      => 'required|string',
            'quantity'     => 'required|integer|min:1',
            'equipment_id' => 'required|exists:equipment,id',
            'booking_date' => 'required|date',
            'return_date'  => 'required|date|after_or_equal:booking_date',
        ]);

        $booking = $this->service->createBooking($validated);

        return response()->json([
            'message' => 'Booking request created successfully',
            'data'    => new EquipmentBookingResource($booking),
        ]);
    }

    
    public function approve($id)
    {
        $booking = EquipmentBooking::findOrFail($id);
        $this->authorize('approve', $booking);

        $booking = $this->service->approveBooking($booking, auth()->id());

        return response()->json([
            'message' => 'Booking approved successfully',
            'data'    => new EquipmentBookingResource($booking),
        ]);
    }

    
    public function reject($id)
    {
        $booking = EquipmentBooking::findOrFail($id);
        $this->authorize('reject', $booking);

        $booking = $this->service->rejectBooking($booking, auth()->id());

        return response()->json([
            'message' => 'Booking rejected successfully',
            'data'    => new EquipmentBookingResource($booking),
        ]);
    }
}
