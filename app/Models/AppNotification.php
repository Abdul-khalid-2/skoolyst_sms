<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    use BelongsToSchoolBranch;

    protected $table = 'app_notifications';

    protected $fillable = [
        'branch_id',
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
