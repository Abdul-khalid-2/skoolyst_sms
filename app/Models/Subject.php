<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id', 'name', 'code',
    ];

    // Relationships
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_subjects', 'subject_id', 'teacher_id')
            ->withPivot('branch_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_subject', 'subject_id', 'class_id')
            ->withTimestamps();
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

