<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Export\SchoolDataExportService;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SchoolDataExportController extends Controller
{
    public function download(): StreamedResponse|RedirectResponse
    {
        $user = auth()->user();

        abort_unless(
            $user && ($user->hasRole('super-admin') || $user->hasRole('admin')),
            403
        );

        try {
            $branchId = $user->hasRole('super-admin') ? null : $user->branch_id;

            return (new SchoolDataExportService($branchId, $user->hasRole('super-admin')))->download();
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('dashboard')
                ->with('error', 'Export failed: ' . $e->getMessage());
        }
    }
}