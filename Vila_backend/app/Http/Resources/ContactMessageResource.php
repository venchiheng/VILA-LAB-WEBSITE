<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'message' => $this->message,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'email_link' => "mailto:{$this->email}",
            'phone_link' => "tel:{$this->phone_number}",
        ];
    }
}

