<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes, HasRoles;
    protected $guard_name = 'web';

    protected $fillable = [
        'school_id',
        'name',
        'email',
        'profile_pic',
        'password',
        'phone',
        'address',
        'gender',
        'dob',
        'role',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class, 'teacher_id');
    }
    public function teacherSubjects() // assigned classes
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects', 'teacher_id', 'subject_id');
    }
    public function teacherClasses() // assigned classes
    {
        return $this->belongsToMany(Classes::class, 'time_tables', 'teacher_id', 'class_id');
    }

    public function timeTables() // assigned classes and subjected currently teaching
    {
        return $this->hasMany(TimeTable::class, 'teacher_id');
    }


    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class, 'student_id');
    }
    public function ParentProfile()
    {
        return $this->hasOne(ParentProfile::class, 'parent_id');
    }
    public function parents()
    {
        return $this->belongsToMany(User::class, 'student_parents', 'student_id', 'parent_id')
            ->withPivot('relationship', 'is_primary');
    }

    // For parents
    public function children()
    {
        return $this->belongsToMany(User::class, 'student_parents', 'parent_id', 'student_id')
            ->withPivot('relationship', 'is_primary')
            ->withTimestamps();
    }

    public function studentParentRelationships()
    {
        return $this->hasMany(StudentParent::class, 'parent_id');
    }

    public function childParentRelationships()
    {
        return $this->hasMany(StudentParent::class, 'student_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
