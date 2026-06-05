<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id', 'fee_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'received_by',
        'notes'
    ];

    // Relationships
    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
