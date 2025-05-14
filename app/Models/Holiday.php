<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'is_recurring',
        'recurring_pattern'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
