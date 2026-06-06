<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    /** Reports hub / landing page. */
    public function index()
    {
        return view('app.reports.index');
    }

    // ── Student Report ───────────────────────────────────────────────────────
    public function students(Request $request)
    {
        $branchId = $this->branchId();
        $classes  = Classes::orderBy('numeric_value')->get();
        $sections = Section::orderBy('name')->get();

        $base = DB::table('student_profiles as sp')
            ->join('users as u', 'u.id', '=', 'sp.student_id')
            ->whereNull('sp.deleted_at')
            ->where('sp.branch_id', $branchId)
            ->when($request->filled('class_id'), fn ($q) => $q->where('sp.class_id', $request->class_id))
            ->when($request->filled('gender'),   fn ($q) => $q->where('u.gender', $request->gender))
            ->when($request->filled('status'),   fn ($q) => $q->where('u.status', $request->status));

        $summary = [
            'total'  => (clone $base)->count(),
            'male'   => (clone $base)->where('u.gender', 'male')->count(),
            'female' => (clone $base)->where('u.gender', 'female')->count(),
            'active' => (clone $base)->where('u.status', 'active')->count(),
        ];

        $byClass = (clone $base)
            ->select('sp.class_id',
                DB::raw("SUM(CASE WHEN u.gender='male' THEN 1 ELSE 0 END) as male"),
                DB::raw("SUM(CASE WHEN u.gender='female' THEN 1 ELSE 0 END) as female"),
                DB::raw('COUNT(*) as total'))
            ->groupBy('sp.class_id')
            ->get();

        $classNames    = $classes->pluck('name', 'id');
        $sectionCounts = Section::select('class_id', DB::raw('COUNT(*) as c'))->groupBy('class_id')->pluck('c', 'class_id');

        return view('app.reports.students', compact('classes', 'sections', 'summary', 'byClass', 'classNames', 'sectionCounts'));
    }

    // ── Attendance Report ────────────────────────────────────────────────────
    public function attendance(Request $request)
    {
        $branchId = $this->branchId();
        $classes  = Classes::orderBy('numeric_value')->get();
        $sections = Section::orderBy('name')->get();

        $sessions = DB::table('attendance_sessions as s')
            ->join('student_attendances as a', 'a.session_id', '=', 's.id')
            ->where('s.branch_id', $branchId)
            ->when($request->filled('from_date'),  fn ($q) => $q->whereDate('s.date', '>=', $request->from_date))
            ->when($request->filled('to_date'),    fn ($q) => $q->whereDate('s.date', '<=', $request->to_date))
            ->when($request->filled('class_id'),   fn ($q) => $q->where('s.class_id', $request->class_id))
            ->when($request->filled('section_id'), fn ($q) => $q->where('s.section_id', $request->section_id));

        $counts = (clone $sessions)
            ->select(
                DB::raw('COUNT(DISTINCT s.id) as sessions'),
                DB::raw("SUM(CASE WHEN a.status='present' THEN 1 ELSE 0 END) as present"),
                DB::raw("SUM(CASE WHEN a.status='absent'  THEN 1 ELSE 0 END) as absent"),
                DB::raw("SUM(CASE WHEN a.status='late'    THEN 1 ELSE 0 END) as late"),
                DB::raw('COUNT(*) as total'))
            ->first();

        $total   = (int) ($counts->total ?? 0);
        $summary = [
            'sessions'   => (int) ($counts->sessions ?? 0),
            'present_pct'=> $total ? round(($counts->present / $total) * 100, 1) : 0,
            'absent_pct' => $total ? round(($counts->absent / $total) * 100, 1) : 0,
            'late_pct'   => $total ? round(($counts->late / $total) * 100, 1) : 0,
        ];

        $byClass = (clone $sessions)
            ->select('s.class_id', 's.section_id',
                DB::raw("SUM(CASE WHEN a.status='present' THEN 1 ELSE 0 END) as present"),
                DB::raw("SUM(CASE WHEN a.status='absent'  THEN 1 ELSE 0 END) as absent"),
                DB::raw("SUM(CASE WHEN a.status='late'    THEN 1 ELSE 0 END) as late"),
                DB::raw('COUNT(*) as total'))
            ->groupBy('s.class_id', 's.section_id')
            ->get();

        $classNames   = $classes->pluck('name', 'id');
        $sectionNames = $sections->pluck('name', 'id');

        return view('app.reports.attendance', compact('classes', 'sections', 'summary', 'byClass', 'classNames', 'sectionNames'));
    }

    // ── Fee Collection Report ────────────────────────────────────────────────
    public function fees(Request $request)
    {
        $branchId = $this->branchId();
        $classes  = Classes::orderBy('numeric_value')->get();

        $base = DB::table('fees as f')
            ->leftJoin('fee_structures as fs', 'fs.id', '=', 'f.structure_id')
            ->where('f.branch_id', $branchId)
            ->whereNull('f.deleted_at')
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('f.due_date', '>=', $request->from_date))
            ->when($request->filled('to_date'),   fn ($q) => $q->whereDate('f.due_date', '<=', $request->to_date))
            ->when($request->filled('class_id'),  fn ($q) => $q->where('fs.class_id', $request->class_id))
            ->when($request->filled('status'),    fn ($q) => $q->where('f.status', $request->status));

        $collected   = (clone $base)->whereIn('f.status', ['paid', 'partial'])->sum(DB::raw('f.amount - f.discount'));
        $outstanding = (clone $base)->whereIn('f.status', ['pending', 'partial'])->sum(DB::raw('f.amount - f.discount'));

        $summary = [
            'collected'   => $collected,
            'outstanding' => $outstanding,
            'invoices'    => (clone $base)->count(),
            'defaulters'  => (clone $base)->where('f.status', 'pending')->distinct('f.student_id')->count('f.student_id'),
        ];

        $byClass = (clone $base)
            ->select('fs.class_id',
                DB::raw('COUNT(*) as invoices'),
                DB::raw("SUM(CASE WHEN f.status IN ('paid','partial') THEN f.amount - f.discount ELSE 0 END) as collected"),
                DB::raw("SUM(CASE WHEN f.status IN ('pending','partial') THEN f.amount - f.discount ELSE 0 END) as outstanding"))
            ->groupBy('fs.class_id')
            ->get();

        $classNames = $classes->pluck('name', 'id');

        return view('app.reports.fees', compact('classes', 'summary', 'byClass', 'classNames'));
    }

    // ── Exam Results Report ──────────────────────────────────────────────────
    public function exams(Request $request)
    {
        $branchId = $this->branchId();
        $classes  = Classes::orderBy('numeric_value')->get();
        $exams    = Exam::where('branch_id', $branchId)->orderByDesc('start_date')->get();

        $summary       = ['results' => 0, 'pass_pct' => 0, 'fail_pct' => 0, 'avg' => 0];
        $bySubject     = collect();
        $gradeDist     = collect();
        $selectedExam  = $request->exam_id;

        if ($selectedExam) {
            $base = DB::table('exam_results as r')
                ->where('r.exam_id', $selectedExam)
                ->whereNull('r.deleted_at')
                ->when($request->filled('class_id'), function ($q) use ($request) {
                    $studentIds = DB::table('student_profiles')->where('class_id', $request->class_id)->pluck('student_id');
                    $q->whereIn('r.student_id', $studentIds);
                });

            $total  = (clone $base)->count();
            $passed = (clone $base)->where('r.marks_obtained', '>=', 40)->count();

            $summary = [
                'results'  => $total,
                'pass_pct' => $total ? round(($passed / $total) * 100, 1) : 0,
                'fail_pct' => $total ? round((($total - $passed) / $total) * 100, 1) : 0,
                'avg'      => round((clone $base)->avg('r.marks_obtained') ?? 0, 1),
            ];

            $bySubject = (clone $base)
                ->join('subjects as su', 'su.id', '=', 'r.subject_id')
                ->select('su.name',
                    DB::raw('ROUND(AVG(r.marks_obtained),1) as avg_marks'),
                    DB::raw('MAX(r.marks_obtained) as highest'),
                    DB::raw('MIN(r.marks_obtained) as lowest'),
                    DB::raw("ROUND(SUM(CASE WHEN r.marks_obtained >= 40 THEN 1 ELSE 0 END) / COUNT(*) * 100, 1) as pass_pct"))
                ->groupBy('su.name')
                ->orderBy('su.name')
                ->get();

            $gradeDist = (clone $base)
                ->select('r.grade', DB::raw('COUNT(*) as cnt'))
                ->whereNotNull('r.grade')
                ->groupBy('r.grade')
                ->get()
                ->map(fn ($g) => (object) [
                    'grade' => $g->grade,
                    'cnt'   => $g->cnt,
                    'pct'   => $total ? round(($g->cnt / $total) * 100, 1) : 0,
                ]);
        }

        return view('app.reports.exams', compact('classes', 'exams', 'summary', 'bySubject', 'gradeDist', 'selectedExam'));
    }

    // ── Library Report ───────────────────────────────────────────────────────
    public function library(Request $request)
    {
        $branchId = $this->branchId();
        $today    = now()->format('Y-m-d');

        $base = DB::table('book_issues as bi')
            ->where('bi.branch_id', $branchId)
            ->whereNull('bi.deleted_at')
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('bi.issue_date', '>=', $request->from_date))
            ->when($request->filled('to_date'),   fn ($q) => $q->whereDate('bi.issue_date', '<=', $request->to_date))
            ->when($request->filled('status'), function ($q) use ($request, $today) {
                $request->status === 'overdue'
                    ? $q->where('bi.status', 'issued')->whereDate('bi.due_date', '<', $today)
                    : $q->where('bi.status', $request->status);
            });

        $summary = [
            'books'    => DB::table('books')->where('branch_id', $branchId)->whereNull('deleted_at')->sum('quantity'),
            'issued'   => (clone $base)->where('bi.status', 'issued')->count(),
            'returned' => (clone $base)->where('bi.status', 'returned')->count(),
            'overdue'  => (clone $base)->where('bi.status', 'issued')->whereDate('bi.due_date', '<', $today)->count(),
        ];

        $mostIssued = (clone $base)
            ->join('books as b', 'b.id', '=', 'bi.book_id')
            ->select('b.title', 'b.author', 'b.category', DB::raw('COUNT(*) as times'))
            ->groupBy('b.id', 'b.title', 'b.author', 'b.category')
            ->orderByDesc('times')
            ->limit(15)
            ->get();

        return view('app.reports.library', compact('summary', 'mostIssued'));
    }

    // ── Inventory Report ─────────────────────────────────────────────────────
    public function inventory(Request $request)
    {
        $branchId = $this->branchId();

        $base = DB::table('inventory_items')
            ->where('branch_id', $branchId)
            ->whereNull('deleted_at')
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->stock === 'low', fn ($q) => $q->whereColumn('quantity', '<=', 'min_quantity')->where('quantity', '>', 0))
            ->when($request->stock === 'out', fn ($q) => $q->where('quantity', '<=', 0));

        $summary = [
            'items' => (clone $base)->count(),
            'stock' => (clone $base)->sum('quantity'),
            'low'   => (clone $base)->whereColumn('quantity', '<=', 'min_quantity')->where('quantity', '>', 0)->count(),
            'out'   => (clone $base)->where('quantity', '<=', 0)->count(),
        ];

        $byCategory = (clone $base)
            ->select('category',
                DB::raw('COUNT(*) as items'),
                DB::raw('SUM(quantity) as stock'),
                DB::raw('SUM(CASE WHEN quantity <= min_quantity AND quantity > 0 THEN 1 ELSE 0 END) as low'),
                DB::raw('SUM(CASE WHEN quantity <= 0 THEN 1 ELSE 0 END) as `out`'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('app.reports.inventory', compact('summary', 'byCategory'));
    }
}
