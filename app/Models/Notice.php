<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'title',
        'content',
        'target_roles',
        'target_classes',
        'start_date',
        'end_date',
        'is_published'
    ];

    protected $casts = [
        'target_roles' => 'array',
        'target_classes' => 'array'
    ];

}

