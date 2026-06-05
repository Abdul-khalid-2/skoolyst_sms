<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use BelongsToSchoolBranch;
    protected $fillable = [
        'branch_id',
        'time_table_id',
        'class_id',
        'section_id',
        'date',
        'recorded_by',
        'notes',
        'status',
    ];

    // Relationships
    public function timeTable()
    {
        return $this->belongsTo(TimeTable::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }
}

