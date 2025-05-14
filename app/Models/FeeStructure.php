<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeStructure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'category_id',
        'class_id',
        'name',
        'amount',
        'frequency',
        'due_date'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

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
