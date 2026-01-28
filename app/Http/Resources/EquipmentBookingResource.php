<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentBookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'member_id'    => $this->member_id,
            'full_name'    => $this->full_name,
            'purpose'      => $this->purpose,
            'quantity'     => $this->quantity,
            'status'       => $this->status,
            'booking_date' => $this->booking_date?->format('Y-m-d'),
            'return_date'  => $this->return_date?->format('Y-m-d'),
            'approved_by'  => $this->approved_by,
            'approve_date' => $this->approve_date?->format('Y-m-d H:i:s'),
            'equipment' => $this->equipment ? [
                'id'           => $this->equipment->id,
                'name'         => $this->equipment->name,
                'image'        => $this->equipment->image,
                'availability' => $this->equipment->availability,
                'condition'    => $this->equipment->condition,
            ] : null,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
