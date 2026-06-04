<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'user_id',
        'action',
        'table_affected',
        'record_id',
        'old_values',
        'new_values',
        'ip_address'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
