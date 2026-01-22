<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'full_name',
        'gender',
        'email',
        // 'qualification',
        'faculty',
        'year',
        'stu_id',
        'phone_number',
        'cv_path',
        'motivation',
        'time_management',
        'availability',
        'status',
        'reviewed_by',
        'review_notes',
    ];

    
    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
