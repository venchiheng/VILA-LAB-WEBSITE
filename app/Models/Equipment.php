<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $timestamps = false;

    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'description',
        'image',
        'availability',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function bookings()
    {
        return $this->hasMany(EquipmentBooking::class);
    }
}
