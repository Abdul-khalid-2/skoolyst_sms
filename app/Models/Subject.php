<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'code',
        'class_id'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_subjects', 'subject_id', 'teacher_id')
            ->withPivot('class_id', 'is_class_teacher');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'subject_classes');
    }

    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubject::class);
    }


    public function subjectTeacherClass()
    {
        return $this->hasMany(TeacherSubject::class, 'subject_id');
    }
}
