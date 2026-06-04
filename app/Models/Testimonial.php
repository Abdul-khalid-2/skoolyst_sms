<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'author',
        'role',
        'content',
        'rating',
        'avatar',
        'order',
    ];
}
