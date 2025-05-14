<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'student_id',
        'structure_id',
        'invoice_number',
        'amount',
        'discount',
        'due_date',
        'status',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'notes'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function structure()
    {
        return $this->belongsTo(FeeStructure::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }
}
