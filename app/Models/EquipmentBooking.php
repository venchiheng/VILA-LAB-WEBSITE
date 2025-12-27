<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',     
        'full_name',      
        'purpose',        
        'quantity',       
        'approved_by',
        'equipment_id',
        'booking_date',
        'approve_date',
        'return_date',
        'status',
    ];
    protected $casts = [
    'booking_date' => 'datetime:Y-m-d',
    'return_date'  => 'datetime:Y-m-d',
    'approve_date' => 'datetime:Y-m-d H:i:s',
];


    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'booking_id');
    }
}
