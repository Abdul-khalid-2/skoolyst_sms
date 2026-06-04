<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'is_published'
    ];

    // Relationships
    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}

