<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeTable extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'class_id',
        'section_id',
        'subject_id',
        'teacher_id',
        'day_of_week',
        'period_name', // Make sure this is included
        'start_time',
        'end_time',
        'room_number',
        'is_break',
        'break_name',
        'is_recurring',
        'effective_from',
        'effective_to'
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'time_table_id');
    }
}

