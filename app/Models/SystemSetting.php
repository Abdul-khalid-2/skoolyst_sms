<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'setting_key',
        'setting_value',
        'is_encrypted'
    ];
}

