<?php

namespace App\Services;

use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MembershipService
{
    public function createApplication(array $data)
    {
        $data['status'] = 'pending';
        return MembershipApplication::create($data);
    }


    private function generateMemberCode(): string
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

            $memberCode = $this->generateMemberCode();

           
            $application->update([
                'status'      => 'approved',
                'reviewed_by' => $admin_id,
            ]);

            $user = User::create([
                'name'        => $application->full_name,
                'email'       => $application->email,
                'password'    => Hash::make($memberCode),
                'role'        => 'member',
                'member_code' => $memberCode,
            ]);

            $user->profile()->create([]);

            return $application;
        });
    }

    public function rejectApplication(MembershipApplication $application, $admin_id, $notes = null)
    {
        $application->update([
            'status'        => 'rejected',
            'reviewed_by'   => $admin_id,
            'review_notes'  => $notes,
        ]);

        return $application;
    }
}
