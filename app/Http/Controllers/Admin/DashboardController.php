<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeePayment;
use App\Models\Section;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {

        
        $numberOfTeachers = User::role('teacher')->count();
        $numberOfStudent  = User::role('student')->count();
        $section          = Section::sum('capacity');

        $earningsData = collect(range(5, 0, -1))->mapWithKeys(function ($monthsAgo) {
            $month = Carbon::now()->subMonths($monthsAgo);
            return [$month->format('M Y') => 0];
        });

        $payments = FeePayment::whereBetween('payment_date', [
            Carbon::now()->subMonths(5)->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->select(['payment_date', 'amount'])->get();

        $earningsData = $earningsData->map(function ($amount, $month) use ($payments) {
            return $payments->filter(function ($payment) use ($month) {
                return $payment->payment_date && Carbon::parse($payment->payment_date)->format('M Y') === $month;
            })->sum('amount');
        })->toArray();

        return view('app.admin.dashboard', compact('numberOfTeachers', 'numberOfStudent', 'section', 'earningsData'));
    }
}
