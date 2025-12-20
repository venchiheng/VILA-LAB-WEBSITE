<?php

namespace App\Services;

use App\Models\EquipmentBooking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquipmentBookingService
{
   
    public function createBooking(array $data)
    {

        return EquipmentBooking::create([
            'member_id'   => $data['member_id'],
            'full_name'   => $data['full_name'],
            'purpose'     => $data['purpose'],
            'quantity'    => $data['quantity'] ?? 1,
            'equipment_id'=> $data['equipment_id'],
            'booking_date'=> Carbon::parse($data['booking_date']),
            'return_date' => Carbon::parse($data['return_date']),
            'status'      => 'pending',
        ]);
    }

    
    public function approveBooking(EquipmentBooking $booking, int $adminId)
    {
        $booking->update([
            'status'      => 'approved',
            'approved_by' => $adminId,
            'approve_date'=> now(),
        ]);

        return $booking;
    }

    
    public function rejectBooking(EquipmentBooking $booking, int $adminId)
    {
        $booking->update([
            'status'      => 'rejected',
            'approved_by' => $adminId,
        ]);

        return $booking;
    }
}
