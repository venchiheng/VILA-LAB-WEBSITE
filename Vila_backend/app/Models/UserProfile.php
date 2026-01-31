<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'role_in_lab',
        'research_area',
        'department',
        'contact_email',
        'bio',
        'social_links',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
