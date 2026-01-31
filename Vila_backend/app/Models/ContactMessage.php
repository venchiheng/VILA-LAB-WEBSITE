<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    // Enable automatic timestamps
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function responses()
    {
        return $this->hasMany(ContactResponse::class, 'message_id');
    }
}
