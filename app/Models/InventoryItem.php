<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'name',
        'category',
        'quantity',
        'min_quantity',
        'unit',
        'location',
        'description'
    ];

    // Relationships
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'item_id');
    }
}

