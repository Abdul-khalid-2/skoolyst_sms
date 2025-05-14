<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentParent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_parents';

    protected $fillable = [
        'student_id',
        'parent_id',
        'relationship',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the student associated with this relationship
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the student profile through student
     */
    public function studentProfile()
    {
        return $this->hasOneThrough(
            StudentProfile::class,
            User::class,
            'id', // Foreign key on users table
            'student_id', // Foreign key on student_profiles table
            'student_id', // Local key on student_parents table
            'id' // Local key on users table
        );
    }

    /**
     * Get the parent associated with this relationship
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get the parent profile through parent
     */
    public function parentProfile()
    {
        return $this->hasOneThrough(
            ParentProfile::class,
            User::class,
            'id', // Foreign key on users table
            'parent_id', // Foreign key on parent_profiles table
            'parent_id', // Local key on student_parents table
            'id' // Local key on users table
        );
    }

    /**
     * Get the school through either student or parent
     */
    public function school()
    {
        return $this->hasOneThrough(
            School::class,
            User::class,
            'id', // Foreign key on users table
            'id', // Foreign key on schools table
            'student_id', // Local key on student_parents table
            'school_id' // Local key on users table
        );
    }

    /**
     * Scope to get primary parents
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope to get by relationship type
     */
    public function scopeRelationship($query, $type)
    {
        return $query->where('relationship', $type);
    }

    /**
     * Get the class information through student profile
     */
    public function class()
    {
        return $this->hasOneThrough(
            Classes::class,
            StudentProfile::class,
            'student_id', // Foreign key on student_profiles table
            'id', // Foreign key on classes table
            'student_id', // Local key on student_parents table
            'class_id' // Local key on student_profiles table
        );
    }

    /**
     * Get the section information through student profile
     */
    public function section()
    {
        return $this->hasOneThrough(
            Section::class,
            StudentProfile::class,
            'student_id', // Foreign key on student_profiles table
            'id', // Foreign key on sections table
            'student_id', // Local key on student_parents table
            'section_id' // Local key on student_profiles table
        );
    }
}
