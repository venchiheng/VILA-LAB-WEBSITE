<?php

namespace App\Services;

use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MembershipService
{
    public function createApplication(array $data)
    {
        
        $applicationData = [
            'full_name'       => $data['full_name'],
            'gender'          => $data['gender'],
            'email'           => $data['email'],
            // 'qualification'   => $data['qualification'],
            'faculty'         => $data['faculty'],
            'year'            => $data['year'],
            'stu_id'          => $data['stu_id'],
            'phone_number'    => $data['phone_number'],
            'cv_path'         => $data['cv_path'] ?? null,
            'motivation'      => $data['motivation'],
            'time_management' => $data['time_management'],
            'availability'    => $data['availability'],
            'status'          => 'pending',
        ];

        return MembershipApplication::create($applicationData);
    }

    private function generateMemberId(): string
    {
        $year = Carbon::now()->year;

        $count = User::where('role', 'member')
            ->whereYear('created_at', $year)
            ->count() + 1;

        return 'V' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function approveApplication(MembershipApplication $application, $admin_id)
    {
        return DB::transaction(function () use ($application, $admin_id) {

            $memberId = $this->generateMemberId();
            $initialPassword = Str::random(12);
            $application->update([
                'status'      => 'approved',
                'reviewed_by' => $admin_id,
            ]);

            $user = User::create([
                'name'      => $application->full_name,
                'email'     => $application->email,
                'password'  => Hash::make($initialPassword),
                'role'      => 'member',
                'member_id' => $memberId,
            ]);
            $user->profile()->create([]);
            return [
            'member_id' => $memberId,
            'password'  => $initialPassword,
            'user'      => $user,
        ];
        });
    }

    public function rejectApplication(MembershipApplication $application, $admin_id, $notes = null)
    {
        $application->update([
            'status'       => 'rejected',
            'reviewed_by'  => $admin_id,
            'review_notes' => $notes,
        ]);

        return $application;
    }
}
