<?php

namespace App\Http\Controllers\Holiday;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'             => 'required|string|max:100',
            'description'       => 'nullable|string',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'is_recurring'      => 'nullable|boolean',
            'recurring_pattern' => 'nullable|in:yearly,monthly,weekly',
        ]);

        $data['is_recurring']      = $request->boolean('is_recurring');
        $data['recurring_pattern'] = $data['is_recurring'] ? ($data['recurring_pattern'] ?? null) : null;

        return $data;
    }

    public function index()
    {
        $branchId = $this->branchId();
        $today    = now()->format('Y-m-d');

        $holidays = Holiday::where('branch_id', $branchId)
            ->orderBy('start_date')
            ->paginate(15);

        $total     = Holiday::where('branch_id', $branchId)->count();
        $upcoming  = Holiday::where('branch_id', $branchId)->whereDate('start_date', '>', $today)->count();
        $recurring = Holiday::where('branch_id', $branchId)->where('is_recurring', true)->count();

        return view('app.holidays.index', compact('holidays', 'total', 'upcoming', 'recurring'));
    }

    public function create()
    {
        return view('app.holidays.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['branch_id'] = $this->branchId();

        Holiday::create($data);

        return redirect()->route('holidays.index')
            ->with('message', 'Holiday added successfully.')->with('alert-type', 'success');
    }

    public function show(Holiday $holiday)
    {
        return view('app.holidays.show', compact('holiday'));
    }

    public function edit(Holiday $holiday)
    {
        return view('app.holidays.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $holiday->update($this->validated($request));

        return redirect()->route('holidays.index')
            ->with('message', 'Holiday updated successfully.')->with('alert-type', 'success');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->route('holidays.index')
            ->with('message', 'Holiday deleted.')->with('alert-type', 'success');
    }
}
