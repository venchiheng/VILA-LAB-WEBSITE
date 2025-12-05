<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressProgress extends Model
{
    public $timestamps = false;

    protected $table = 'progress_progress';

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
