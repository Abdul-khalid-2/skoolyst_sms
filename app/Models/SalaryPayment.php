<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'teacher_id',
        'payment_date',
        'month_year',
        'amount',
        'bonus',
        'deductions',
        'tax_amount',
        'payment_method',
        'transaction_reference',
        'status',
        'notes',
        'recorded_by'
    ];

    protected $dates = ['payment_date', 'deleted_at'];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Helper methods
    public function getNetSalaryAttribute()
    {
        return $this->amount + $this->bonus - $this->deductions - $this->tax_amount;
    }

    public function scopeForMonth($query, $monthYear)
    {
        return $query->where('month_year', $monthYear);
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }
}
