<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'school_id',
        'setting_key',
        'setting_value',
        'is_encrypted'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
