<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;
    protected $table = 'student_attendances';

    protected $fillable = [
        'session_id',
        'user_id',
        'status',
        'remarks'
    ];

    // Relationships
    public function session()
    {
        return $this->belongsTo(AttendanceSession::class, 'session_id');
    }

    // public function student()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    // public function students()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
