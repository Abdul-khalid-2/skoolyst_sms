<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeStructure extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'category_id',
        'class_id',
        'name',
        'amount',
        'frequency',
        'due_date'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(FeeCategory::class, 'category_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class, 'structure_id');
    }
}

