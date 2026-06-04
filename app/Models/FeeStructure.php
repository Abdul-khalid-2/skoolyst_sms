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
        return $this->belongsTo(FeeCategory::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}

