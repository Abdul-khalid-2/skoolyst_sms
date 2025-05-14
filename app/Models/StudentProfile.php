<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'school_id',
        'admission_no',
        'admission_date',
        'class_id',
        'section_id',
        'id_card_issued',
        'id_card_number',
        'blood_group',
        'documents',
        'signature',
    ];

    protected $casts = [
        'medical_history' => 'array',
        'transport_details' => 'array',
        'hobbies' => 'array',
        'awards' => 'array',
        'documents' => 'array'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'student_parents')
            ->withPivot('relationship', 'is_primary');
    }
    public function parentRelationships()
    {
        return $this->hasMany(StudentParent::class, 'student_id', 'student_id');
    }
}
