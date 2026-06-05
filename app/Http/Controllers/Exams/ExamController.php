<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index()
    {
        $branchId = $this->branchId();

        $exams = Exam::where('branch_id', $branchId)
            ->withCount(['schedules', 'results'])
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function (Exam $exam) {
                $today = now()->toDateString();
                $exam->status = match(true) {
                    $exam->end_date   < $today => 'completed',
                    $exam->start_date > $today => 'upcoming',
                    default                    => 'ongoing',
                };
                return $exam;
            });

        $total     = $exams->count();
        $upcoming  = $exams->where('status', 'upcoming')->count();
        $ongoing   = $exams->where('status', 'ongoing')->count();
        $completed = $exams->where('status', 'completed')->count();

        return view('app.exams.index', compact('exams', 'total', 'upcoming', 'ongoing', 'completed'));
    }

    public function create()
    {
        return view('app.exams.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'is_published' => 'nullable|boolean',
        ]);

        $data['branch_id']    = $this->branchId();
        $data['is_published'] = $request->boolean('is_published');

        $exam = Exam::create($data);

        return redirect()->route('exams.show', $exam)
            ->with('message', 'Exam created successfully.')
            ->with('alert-type', 'success');
    }

    public function show(Exam $exam)
    {
        $exam->load(['schedules' => function ($q) {
            $q->with(['subject', 'schoolClass'])->orderBy('exam_date')->orderBy('start_time');
        }]);

        $today         = now()->toDateString();
        $exam->status  = match(true) {
            $exam->end_date   < $today => 'completed',
            $exam->start_date > $today => 'upcoming',
            default                    => 'ongoing',
        };

        $resultsCount = $exam->results()->count();

        return view('app.exams.show', compact('exam', 'resultsCount'));
    }

    public function edit(Exam $exam)
    {
        return view('app.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'is_published' => 'nullable|boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $exam->update($data);

        return redirect()->route('exams.show', $exam)
            ->with('message', 'Exam updated successfully.')
            ->with('alert-type', 'success');
    }

    public function destroy(Exam $exam)
    {
        $exam->results()->delete();
        $exam->schedules()->delete();
        $exam->delete();

        return redirect()->route('exams.index')
            ->with('message', 'Exam deleted.')
            ->with('alert-type', 'success');
    }
}
