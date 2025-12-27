<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EquipmentBooking;

class EquipmentBookingPolicy
{
    /**
     * Admin & Member can see the list.
     * Admin sees all, member sees only their own.
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'member']);
    }

    /**
     * Admin can view any booking, member only their own.
     */
    public function view(User $user, EquipmentBooking $booking)
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->role === 'member' && $booking->member_id === $user->id;
    }

    /**
     * Only members can create a booking
     */
    public function create(User $user)
    {
        return $user->role === 'member';
    }

    /**
     * Only admin can approve bookings
     */
    public function approve(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Only admin can reject bookings
     */
    public function reject(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Only admin can mark as returned
     * (you can customize to allow member returning if needed)
     */
    public function return(User $user, EquipmentBooking $booking)
    {
        return $user->role === 'admin' && $booking->status === 'approved';
    }
}
