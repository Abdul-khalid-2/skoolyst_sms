<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $fillable = [
        'school_id',
        'time_table_id',
        'date',
        'recorded_by',
        'notes'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

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
