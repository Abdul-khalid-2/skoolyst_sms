<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'class_id',
        'name',
        'capacity'
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function students()
    {
        return $this->hasMany(StudentProfile::class);
    }
}

