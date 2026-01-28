<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'title',
        'authors',
        'published_date',
    ];

    protected $casts = [
        'published_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
