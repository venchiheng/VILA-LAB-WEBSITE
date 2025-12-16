<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray($request)
{
    return [
        'id' => $this->id,
        'full_name' => $this->full_name,
        'email' => $this->email,
        'status' => $this->status,

        'member_code' => $this->when(
            $this->status === 'approved',
            optional($this->user)->member_code
        ),

        'reviewed_by' => $this->when($this->reviewed_by, function () {
            return $this->reviewer->name ?? null;
        }),

        'cv_path' => $this->cv_path,
        'google_form_response_url' => $this->google_form_response_url,
        'review_notes' => $this->review_notes,
        'submitted_at' => $this->created_at->toDateTimeString(),
    ];
}

}
