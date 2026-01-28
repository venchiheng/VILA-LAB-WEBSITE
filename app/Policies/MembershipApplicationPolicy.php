<?php

namespace App\Policies;

use App\Models\MembershipApplication;
use App\Models\User;

class MembershipApplicationPolicy
{
    // Only admin can approve
    public function approve(User $user, MembershipApplication $application): bool
    {
        return $user->isAdmin();
    }

    // Only admin can reject
    public function reject(User $user, MembershipApplication $application): bool
    {
        return $user->isAdmin();
    }

    // Optional: only admin can view all applications
    public function viewAny(User $user): bool
    {
       return $user->isAdmin();
    }

    // Optional: only admin can view a single application
    public function view(User $user, MembershipApplication $application): bool
    {
        return $user->isAdmin();
    }
}
