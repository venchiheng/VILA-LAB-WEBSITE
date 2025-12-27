<?php

namespace App\Services;

use App\Models\EquipmentBooking;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class EquipmentBookingService
{
    public function create(array $data): EquipmentBooking
    {
        $equipment = Equipment::findOrFail($data['equipment_id']);

        if (Carbon::parse($data['booking_date'])->gt(Carbon::parse($data['return_date']))) {
            throw new Exception('Return date must be after booking date');
        }

        $booking = EquipmentBooking::create([
            'member_id'    => $data['member_id'],
            'full_name'    => $data['full_name'],
            'purpose'      => $data['purpose'] ?? null,
            'quantity'     => $data['quantity'] ?? 1,
            'equipment_id' => $equipment->id,
            'booking_date' => $data['booking_date'],
            'return_date'  => $data['return_date'],
            'status'       => 'pending',
        ]);

        // Load the relation for Resource
        return $booking->load('equipment');
    }

    public function approve(EquipmentBooking $booking, int $adminId): EquipmentBooking
    {
        DB::transaction(function () use ($booking, $adminId) {
            if ($booking->status !== 'pending') {
                throw new Exception('Booking is not pending');
            }

            $equipment = $booking->equipment;

            // Calculate total approved quantity for overlapping bookings
            $totalBooked = EquipmentBooking::where('equipment_id', $equipment->id)
                ->where('status', 'approved')
                ->where(function ($query) use ($booking) {
                    $query->whereBetween('booking_date', [$booking->booking_date, $booking->return_date])
                        ->orWhereBetween('return_date', [$booking->booking_date, $booking->return_date])
                        ->orWhere(function ($q) use ($booking) {
                            $q->where('booking_date', '<=', $booking->booking_date)
                                ->where('return_date', '>=', $booking->return_date);
                        });
                })
                ->sum('quantity');

            // Check if approving exceeds stock
            if (($totalBooked + $booking->quantity) > $equipment->stock) {
                throw new Exception('Not enough equipment available to approve this booking.');
            }

            // Approve booking
            $booking->update([
                'status' => 'approved',
                'approved_by' => $adminId,
                'approve_date' => now(),
            ]);
        });

        return $booking->fresh()->load('equipment');
    }


    public function reject(EquipmentBooking $booking, int $adminId): EquipmentBooking
    {
        if ($booking->status !== 'pending') {
            throw new Exception('Booking is not pending');
        }

        $booking->update([
            'status'      => 'rejected',
            'approved_by' => $adminId,
        ]);

        return $booking->fresh()->load('equipment');
    }

    public function return(EquipmentBooking $booking): EquipmentBooking
    {
        DB::transaction(function () use ($booking) {

            if ($booking->status !== 'approved') {
                throw new Exception('Booking is not approved');
            }

            $booking->update([
                'status' => 'returned',
            ]);

            $booking->equipment->update([
                'availability' => 'available',
            ]);
        });

        return $booking->fresh()->load('equipment');
    }
}
