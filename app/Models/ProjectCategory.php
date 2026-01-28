<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
