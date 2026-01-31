<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactResponse extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'message_id',
        'admin_id',
        'response_text',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function message()
    {
        return $this->belongsTo(ContactMessage::class, 'message_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
