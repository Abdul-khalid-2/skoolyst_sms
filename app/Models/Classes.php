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

    public function timetables()
    {
        return $this->hasMany(TimeTable::class, 'class_id');
    }
}

