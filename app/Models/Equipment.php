<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $timestamps = true;

    protected $table = 'equipment';
    
    protected $fillable = [
        'name',
        'description',
        'image',
        'availability',
        'condition',
        'stock',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bookings()
    {
        return $this->hasMany(EquipmentBooking::class);
    }
}
