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
        'teacher_id'
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

    public function classTeachersSubjects()
    {
        return $this->hasMany(TeacherSubject::class, 'class_id');
    }

    /**
     * The class teacher stored directly on the class (classes.teacher_id).
     */
    public function classTeacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Teacher profiles marked as class-teacher of this class
     * (teacher_profiles.class_teacher_of). Use ->teacher for the user.
     */
    public function classTeacherProfiles()
    {
        return $this->hasMany(TeacherProfile::class, 'class_teacher_of');
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

