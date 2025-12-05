<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBooking extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'equipment_id',
        'admin_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'created_at',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'booking_id');
    }
}
