<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryTransaction extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'item_id',
        'user_id',
        'quantity',
        'transaction_type',
        'reference_number',
        'notes'
    ];

    // Relationships
    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

