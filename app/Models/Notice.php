<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'title',
        'content',
        'target_roles',
        'target_classes',
        'start_date',
        'end_date',
        'is_published'
    ];

    protected $casts = [
        'target_roles' => 'array',
        'target_classes' => 'array'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
