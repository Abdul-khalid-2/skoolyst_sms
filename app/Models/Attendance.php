<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;
    protected $table = 'student_attendances';

    protected $fillable = [
        'branch_id',
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
