<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'status',
        'is_featured',
        'banner_image',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function progressUpdates()
    {
        return $this->hasMany(ProgressProgress::class);
    }

    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_members')->withPivot('role');
    }
}
