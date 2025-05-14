<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'is_published'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}
