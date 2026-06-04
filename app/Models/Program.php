<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'order',
    ];
}
