<?php

namespace App\Services\Fees;

use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FeePaymentService
{
    public function decorate(Fee $fee): Fee
    {
        $netPayable = (float) $fee->amount - (float) $fee->discount;
        $paid = (float) $fee->payments->sum('amount');
        $balance = round($netPayable - $paid, 2);

        $fee->net_payable = round($netPayable, 2);
        $fee->paid = round($paid, 2);
        $fee->balance = $balance;
        $fee->is_overdue = $balance > 0
            && $fee->status !== 'cancelled'
            && $fee->due_date
            && Carbon::parse($fee->due_date)->isPast();

        return $fee;
    }

    public function createInvoice(array $data, int $receivedBy, ?float $amountReceived = null): Fee
    {
        $data['invoice_number'] = $data['invoice_number'] ?? ('INV-' . strtoupper(Str::random(8)));
        $data['discount'] = $data['discount'] ?? 0;
        $data['status'] = 'pending';

        $fee = Fee::create($data);

        if ($amountReceived !== null && $amountReceived > 0) {
            $this->recordPayment($fee, [
                'amount'                => $amountReceived,
                'payment_date'          => $data['payment_date'] ?? now()->format('Y-m-d'),
                'payment_method'        => $data['payment_method'] ?? null,
                'transaction_reference' => $data['transaction_reference'] ?? null,
                'notes'                 => $data['notes'] ?? null,
            ], $receivedBy);
        }

        return $fee->fresh(['student', 'structure.category', 'structure.schoolClass', 'payments.receivedBy']);
    }

    public function recordPayment(Fee $fee, array $data, int $receivedBy): FeePayment
    {
        if ($fee->status === 'cancelled') {
            throw ValidationException::withMessages([
                'amount' => ['Cannot record payment on a cancelled invoice.'],
            ]);
        }

        $net = round((float) $fee->amount - (float) $fee->discount, 2);
        $alreadyPaid = (float) $fee->payments()->sum('amount');
        $balance = round($net - $alreadyPaid, 2);
        $amount = round((float) $data['amount'], 2);

        if ($amount <= 0) {
            throw ValidationException::withMessages([
                'amount' => ['Payment amount must be greater than zero.'],
            ]);
        }

        if ($amount > $balance + 0.009) {
            throw ValidationException::withMessages([
                'amount' => ['Payment amount cannot exceed the outstanding balance of PKR ' . number_format($balance, 2) . '.'],
            ]);
        }

        $payment = FeePayment::create([
            'branch_id'             => $fee->branch_id,
            'fee_id'                => $fee->id,
            'amount'                => $amount,
            'payment_date'          => $data['payment_date'] ?? now()->format('Y-m-d'),
            'payment_method'        => $data['payment_method'] ?? null,
            'transaction_reference' => $data['transaction_reference'] ?? null,
            'notes'                 => $data['notes'] ?? null,
            'received_by'           => $receivedBy,
        ]);

        $this->syncFeeStatus($fee->fresh());

        return $payment->load(['fee.student', 'receivedBy']);
    }

    public function syncFeeStatus(Fee $fee): void
    {
        if ($fee->status === 'cancelled') {
            return;
        }

        $net = round((float) $fee->amount - (float) $fee->discount, 2);
        $paid = round((float) $fee->payments()->sum('amount'), 2);
        $lastPaymentDate = $fee->payments()->max('payment_date');

        if ($paid <= 0) {
            $fee->status = 'pending';
            $fee->payment_date = null;
        } elseif ($paid >= $net - 0.009) {
            $fee->status = 'paid';
            $fee->payment_date = $lastPaymentDate;
        } else {
            $fee->status = 'partial';
            $fee->payment_date = $lastPaymentDate;
        }

        $latestPayment = $fee->payments()->orderByDesc('id')->first();
        if ($latestPayment) {
            $fee->payment_method = $latestPayment->payment_method;
            $fee->transaction_reference = $latestPayment->transaction_reference;
        }

        $fee->save();
    }
}
