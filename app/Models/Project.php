<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'status',
        'is_featured',
        'banner_image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    // public function publications()
    // {
    //     return $this->hasMany(Publication::class);
    // }

    // public function progress()
    // {
    //     return $this->hasMany(ProjectProgress::class);
    // }

    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_members')->withPivot('role');
    }
}
