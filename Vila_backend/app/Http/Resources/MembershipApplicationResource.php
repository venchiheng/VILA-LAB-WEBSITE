<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipApplicationResource extends JsonResource
{
  
    public function toArray($request)
     
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'email' => $this->email,
            // 'qualification' => $this->qualification,
            'faculty' => $this->faculty,
            'year' => $this->year,
            'stu_id' => $this->stu_id,
            'phone_number' => $this->phone_number,
            'cv_path' => $this->cv_path ? asset('storage/' . $this->cv_path) : null,
            'motivation' => $this->motivation,
            'time_management' => $this->time_management,
            'availability' => $this->availability,
            'status' => $this->status,
            'member_id' => $this->when(
                $this->status === 'approved',
                optional($this->user)->member_id
            ),
            'reviewed_by' => $this->when($this->reviewed_by, function () {
                return $this->reviewer->name ?? null;
            }),
            'review_notes' => $this->review_notes,
            'submitted_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
