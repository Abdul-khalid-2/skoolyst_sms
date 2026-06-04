<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentProfile extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'parent_id',
        'branch_id',
        'occupation',
        'employer',
        'income_range',
        'education_level',
        'relation_type',
        'is_primary',
        'emergency_contact'
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(User::class, 'student_parents', 'parent_id', 'student_id')
            ->withPivot('relationship', 'is_primary');
    }
    public function studentRelationships()
    {
        return $this->hasMany(StudentParent::class, 'parent_id', 'parent_id');
    }
}

