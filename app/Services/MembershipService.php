<?php

namespace App\Services;
use App\Models\MembershipApplication;
use App\Models\User;
class MembershipService
{
    public function createApplication(array $data)
    {
        $data['status']='pending';
        return MembershipApplication::create($data);
    }

    public function approveApplication(MembershipApplication $application, $admin_id)
    {
        $application->status = 'approved';
        $application->reviewed_by = $admin_id;
        $application->save();

        User::create([
            'name' => $application->full_name,
            'email' => $application->email,
            'password' => bcrypt('defaultpassword'),
            'role' => 'member',
        ]);

        return $application;
    }
     public function rejectApplication(MembershipApplication $application, $admin_id, $notes = null)
    {
        $application->status = 'rejected';
        $application->reviewed_by = $admin_id;
        $application->review_notes = $notes;
        $application->save();

        return $application;
    }
}
