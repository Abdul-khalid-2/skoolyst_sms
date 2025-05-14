<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'numeric_value',
        'teacher_id'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // public function classTeacher()
    // {
    //     return $this->belongsTo(User::class, 'teacher_id');
    // }
    public function classStudents()
    {
        return $this->hasMany(StudentProfile::class, 'class_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    // remove this if no use 
    // public function subjects()
    // {
    //     return $this->belongsToMany(Subject::class, 'subject_classes');
    // }




    // relationships of class with teacher and subject 


    public function classTeachersSubjects()
    {
        return $this->hasMany(TeacherSubject::class, 'class_id');
    }
}
