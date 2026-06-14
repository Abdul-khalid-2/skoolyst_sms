<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionSubjectTeacher extends Model
{
    protected $table = 'section_subject_teacher';

    protected $fillable = [
        'branch_id',
        'section_id',
        'subject_id',
        'teacher_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function class()
    {
        return $this->hasOneThrough(
            Classes::class,
            Section::class,
            'id',
            'id',
            'section_id',
            'class_id'
        );
    }

    /** @deprecated Use class() instead */
    public function schoolClass()
    {
        return $this->class();
    }
}
