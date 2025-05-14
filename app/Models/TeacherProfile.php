<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'school_id',
        'employee_id',
        'qualification',
        'specialization',
        'experience_years',
        'joining_date',
        'salary_grade',
        'bank_details',
        'emergency_contact',
        'documents',
        'signature',
        'bio',
        'social_links',
        'is_class_teacher',
        'class_teacher_of',
        'base_salary',
        'current_salary',
    ];

    protected $casts = [
        'bank_details' => 'array',
        'emergency_contact' => 'array',
        'documents' => 'array',
        'social_links' => 'array'
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classTeacherOf()
    {
        return $this->belongsTo(Classes::class, 'class_teacher_of');
    }
}
