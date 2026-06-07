<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'name',
        'numeric_value',
    ];

    // Relationships
    public function classStudents()
    {
        return $this->hasMany(StudentProfile::class, 'class_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    /**
     * Teacher profile for the class teacher (teacher_profiles.class_teacher_of).
     */
    public function classTeacherProfile()
    {
        return $this->hasOne(TeacherProfile::class, 'class_teacher_of');
    }

    public function classTeacherProfiles()
    {
        return $this->hasMany(TeacherProfile::class, 'class_teacher_of');
    }

    public function classTeacher()
    {
        return $this->hasOneThrough(
            User::class,
            TeacherProfile::class,
            'class_teacher_of',
            'id',
            'id',
            'teacher_id'
        );
    }

    public function timetables()
    {
        return $this->hasMany(TimeTable::class, 'class_id');
    }

    /**
     * Subjects this class offers (curriculum) — class_subject pivot.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id')
            ->withTimestamps();
    }
}

