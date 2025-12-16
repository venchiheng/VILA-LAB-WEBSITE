<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    use HasFactory;

    protected $table = 'membership_applications';

    protected $fillable = [
        'full_name',
        'email',
        'cv_path',
        'google_form_response_url',
        'status',
        'reviewed_by',
        'review_notes',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}

