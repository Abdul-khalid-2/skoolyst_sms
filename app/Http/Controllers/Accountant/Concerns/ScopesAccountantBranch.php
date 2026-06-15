<?php

namespace App\Http\Controllers\Accountant\Concerns;

use App\Models\Fee;
use App\Models\FeePayment;

trait ScopesAccountantBranch
{
    protected function branchId(): ?int
    {
        return auth()->user()?->branch_id;
    }

    protected function ensureFeeInBranch(Fee $fee): void
    {
        $branchId = $this->branchId();

        if ($branchId && (int) $fee->branch_id !== (int) $branchId) {
            abort(404);
        }
    }

    protected function ensurePaymentInBranch(FeePayment $payment): void
    {
        $branchId = $this->branchId();

        if ($branchId && (int) $payment->branch_id !== (int) $branchId) {
            abort(404);
        }
    }
}
