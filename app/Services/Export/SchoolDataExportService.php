<?php

namespace App\Services\Export;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamSchedule;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\InventoryItem;
use App\Models\Notice;
use App\Models\Section;
use App\Models\Setting;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SchoolDataExportService
{
    public function __construct(
        private readonly ?int $branchId,
        private readonly bool $isSuperAdmin,
    ) {}

    public function download(): StreamedResponse
    {
        $filename = 'school-data-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            $out = fopen('php://output', 'w');
            if ($out === false) {
                throw new \RuntimeException('Unable to open output stream.');
            }

            fwrite($out, "\xEF\xBB\xBF");

            $this->writeOverview($out);
            $this->writeSection($out, 'STUDENTS', $this->studentHeaders(), $this->studentRows());
            $this->writeSection($out, 'TEACHERS', $this->teacherHeaders(), $this->teacherRows());
            $this->writeSection($out, 'PARENTS', $this->parentHeaders(), $this->parentRows());
            $this->writeSection($out, 'FEES', $this->feeHeaders(), $this->feeRows());
            $this->writeSection($out, 'FEE PAYMENTS', $this->feePaymentHeaders(), $this->feePaymentRows());
            $this->writeSection($out, 'TIMETABLE', $this->timetableHeaders(), $this->timetableRows());
            $this->writeSection($out, 'EXAMS', $this->examHeaders(), $this->examRows());
            $this->writeSection($out, 'EXAM SCHEDULES', $this->examScheduleHeaders(), $this->examScheduleRows());
            $this->writeSection($out, 'EXAM RESULTS', $this->examResultHeaders(), $this->examResultRows());
            $this->writeSection($out, 'BOOK ISSUES', $this->bookIssueHeaders(), $this->bookIssueRows());
            $this->writeSection($out, 'OTHER DATA', $this->otherHeaders(), $this->otherRows());

            fclose($out);
        }, $filename, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate',
            'Pragma'              => 'no-cache',
        ]);
    }

    private function writeOverview($out): void
    {
        $school = Setting::get();
        $schoolName = $school->school_name ?? $school->app_name ?? config('app.name', 'School');

        fputcsv($out, ['School Data Export']);
        fputcsv($out, ['School', $schoolName]);
        fputcsv($out, ['Generated', now()->format('l, d M Y h:i A')]);
        fputcsv($out, ['Exported By', auth()->user()?->name ?? 'Admin']);
        fputcsv($out, ['Scope', $this->isSuperAdmin ? 'All branches' : (User::find(auth()->id())?->branch?->name ?? 'Current branch')]);
        fputcsv($out, []);
    }

    private function writeSection($out, string $title, array $headers, array $rows): void
    {
        fputcsv($out, []);
        fputcsv($out, ['=== ' . $title . ' ===']);
        fputcsv($out, $headers);

        foreach ($rows as $row) {
            fputcsv($out, array_map(fn ($cell) => $this->sanitizeCell($cell), $row));
        }
    }

    private function sanitizeCell(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        $text = (string) $value;
        $text = str_replace(["\r\n", "\r", "\n"], ' ', $text);

        return $text;
    }

    private function fmtDate($value): string
    {
        return $value ? Carbon::parse($value)->format('d M Y') : '';
    }

    private function fmtTime($value): string
    {
        return $value ? Carbon::parse($value)->format('h:i A') : '';
    }

    private function branchColumn(): array
    {
        return $this->isSuperAdmin ? ['Branch'] : [];
    }

    private function branchValue($model): array
    {
        if (! $this->isSuperAdmin) {
            return [];
        }

        $branch = $model->branch ?? $model->student?->branch ?? $model->teacher?->branch ?? null;

        return [$branch?->name ?? ''];
    }

    private function studentHeaders(): array
    {
        return array_merge(
            ['#', 'Name', 'Email', 'Phone', 'Gender', 'DOB', 'Address', 'Status'],
            ['Admission No', 'Admission Date', 'Class', 'Section', 'Blood Group', 'ID Card No'],
            $this->branchColumn()
        );
    }

    private function studentRows(): array
    {
        return User::role('student')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['studentProfile.class', 'studentProfile.section', 'branch'])
            ->orderBy('name')
            ->get()
            ->values()
            ->map(fn ($u, $i) => array_merge([
                $i + 1,
                $u->name,
                $u->email,
                $u->phone ?? '',
                ucfirst($u->gender ?? ''),
                $this->fmtDate($u->dob),
                $u->address ?? '',
                ucfirst($u->status ?? 'active'),
                $u->studentProfile?->admission_no ?? '',
                $this->fmtDate($u->studentProfile?->admission_date),
                $u->studentProfile?->class?->name ?? '',
                $u->studentProfile?->section?->name ?? '',
                $u->studentProfile?->blood_group ?? '',
                $u->studentProfile?->id_card_number ?? '',
            ], $this->branchValue($u)))
            ->all();
    }

    private function teacherHeaders(): array
    {
        return array_merge(
            ['#', 'Name', 'Email', 'Phone', 'Gender', 'DOB', 'Status'],
            ['Employee ID', 'Qualification', 'Specialization', 'Experience (Yrs)', 'Joining Date', 'Salary Grade', 'Class Teacher Of', 'Emergency Contact'],
            $this->branchColumn()
        );
    }

    private function teacherRows(): array
    {
        return User::role('teacher')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['teacherProfile.classTeacherOf', 'branch'])
            ->orderBy('name')
            ->get()
            ->values()
            ->map(fn ($u, $i) => array_merge([
                $i + 1,
                $u->name,
                $u->email,
                $u->phone ?? '',
                ucfirst($u->gender ?? ''),
                $this->fmtDate($u->dob),
                ucfirst($u->status ?? 'active'),
                $u->teacherProfile?->employee_id ?? '',
                $u->teacherProfile?->qualification ?? '',
                $u->teacherProfile?->specialization ?? '',
                $u->teacherProfile?->experience_years ?? '',
                $this->fmtDate($u->teacherProfile?->joining_date),
                $u->teacherProfile?->salary_grade ?? '',
                $u->teacherProfile?->classTeacherOf?->name ?? '',
                is_array($u->teacherProfile?->emergency_contact)
                    ? json_encode($u->teacherProfile->emergency_contact)
                    : ($u->teacherProfile?->emergency_contact ?? ''),
            ], $this->branchValue($u)))
            ->all();
    }

    private function parentHeaders(): array
    {
        return array_merge(
            ['#', 'Name', 'Email', 'Phone', 'Gender', 'Address', 'Status'],
            ['Occupation', 'Employer', 'Income Range', 'Education', 'Emergency Contact', 'Linked Children'],
            $this->branchColumn()
        );
    }

    private function parentRows(): array
    {
        return User::role('parent')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['parentProfile', 'children', 'branch'])
            ->orderBy('name')
            ->get()
            ->values()
            ->map(fn ($u, $i) => array_merge([
                $i + 1,
                $u->name,
                $u->email,
                $u->phone ?? '',
                ucfirst($u->gender ?? ''),
                $u->address ?? '',
                ucfirst($u->status ?? 'active'),
                $u->parentProfile?->occupation ?? '',
                $u->parentProfile?->employer ?? '',
                $u->parentProfile?->income_range ?? '',
                $u->parentProfile?->education_level ?? '',
                $u->parentProfile?->emergency_contact ?? '',
                $u->children->pluck('name')->implode(', '),
            ], $this->branchValue($u)))
            ->all();
    }

    private function feeHeaders(): array
    {
        return ['#', 'Invoice No', 'Student', 'Class', 'Fee Type', 'Amount', 'Discount', 'Net Amount', 'Due Date', 'Status', 'Total Paid', 'Balance'];
    }

    private function feeRows(): array
    {
        return Fee::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['student.studentProfile.class', 'structure', 'payments'])
            ->orderByDesc('due_date')
            ->get()
            ->values()
            ->map(function ($fee, $i) {
                $net = (float) $fee->amount - (float) ($fee->discount ?? 0);
                $paid = (float) $fee->payments->sum('amount');

                return [
                    $i + 1,
                    $fee->invoice_number ?? '',
                    $fee->student?->name ?? '',
                    $fee->student?->studentProfile?->class?->name ?? '',
                    $fee->structure?->name ?? '',
                    number_format((float) $fee->amount, 2, '.', ''),
                    number_format((float) ($fee->discount ?? 0), 2, '.', ''),
                    number_format($net, 2, '.', ''),
                    $this->fmtDate($fee->due_date),
                    ucfirst($fee->status ?? ''),
                    number_format($paid, 2, '.', ''),
                    number_format(max(0, $net - $paid), 2, '.', ''),
                ];
            })
            ->all();
    }

    private function feePaymentHeaders(): array
    {
        return ['#', 'Payment Date', 'Student', 'Invoice No', 'Amount', 'Method', 'Reference', 'Received By', 'Notes'];
    }

    private function feePaymentRows(): array
    {
        return FeePayment::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['fee.student', 'receivedBy'])
            ->orderByDesc('payment_date')
            ->get()
            ->values()
            ->map(fn ($p, $i) => [
                $i + 1,
                $this->fmtDate($p->payment_date),
                $p->fee?->student?->name ?? '',
                $p->fee?->invoice_number ?? '',
                number_format((float) $p->amount, 2, '.', ''),
                ucfirst($p->payment_method ?? ''),
                $p->transaction_reference ?? '',
                $p->receivedBy?->name ?? '',
                $p->notes ?? '',
            ])
            ->all();
    }

    private function timetableHeaders(): array
    {
        return array_merge(
            ['#', 'Class', 'Section', 'Day', 'Period', 'Type', 'Subject / Event', 'Teacher', 'Start', 'End', 'Room'],
            $this->branchColumn()
        );
    }

    private function timetableRows(): array
    {
        return TimeTable::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['class', 'section', 'subject', 'teacher', 'branch'])
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->values()
            ->map(fn ($t, $i) => array_merge([
                $i + 1,
                $t->class?->name ?? '',
                $t->section?->name ?? '',
                $t->day_of_week,
                $t->period_name,
                $t->is_break ? 'Break' : 'Class',
                $t->is_break ? ($t->break_name ?? 'Break') : ($t->subject?->name ?? ''),
                $t->teacher?->name ?? '',
                $this->fmtTime($t->start_time),
                $this->fmtTime($t->end_time),
                $t->room_number ?? '',
            ], $this->branchValue($t)))
            ->all();
    }

    private function examHeaders(): array
    {
        return array_merge(['#', 'Exam Name', 'Description', 'Start Date', 'End Date', 'Published'], $this->branchColumn());
    }

    private function examRows(): array
    {
        return Exam::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with('branch')
            ->orderByDesc('start_date')
            ->get()
            ->values()
            ->map(fn ($e, $i) => array_merge([
                $i + 1,
                $e->name,
                $e->description ?? '',
                $this->fmtDate($e->start_date),
                $this->fmtDate($e->end_date),
                $e->is_published ? 'Yes' : 'No',
            ], $this->branchValue($e)))
            ->all();
    }

    private function examScheduleHeaders(): array
    {
        return ['#', 'Exam', 'Class', 'Subject', 'Date', 'Start', 'End', 'Room', 'Max Marks', 'Pass Marks'];
    }

    private function examScheduleRows(): array
    {
        return ExamSchedule::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['exam', 'schoolClass', 'subject'])
            ->orderBy('exam_date')
            ->get()
            ->values()
            ->map(fn ($s, $i) => [
                $i + 1,
                $s->exam?->name ?? '',
                $s->schoolClass?->name ?? '',
                $s->subject?->name ?? '',
                $this->fmtDate($s->exam_date),
                $this->fmtTime($s->start_time),
                $this->fmtTime($s->end_time),
                $s->room_number ?? '',
                $s->max_marks ?? '',
                $s->passing_marks ?? '',
            ])
            ->all();
    }

    private function examResultHeaders(): array
    {
        return ['#', 'Exam', 'Student', 'Subject', 'Marks', 'Grade', 'Remarks', 'Published At'];
    }

    private function examResultRows(): array
    {
        return ExamResult::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['exam', 'student', 'subject'])
            ->orderByDesc('created_at')
            ->get()
            ->values()
            ->map(fn ($r, $i) => [
                $i + 1,
                $r->exam?->name ?? '',
                $r->student?->name ?? '',
                $r->subject?->name ?? '',
                $r->marks_obtained ?? '',
                $r->grade ?? '',
                $r->remarks ?? '',
                $this->fmtDate($r->published_at),
            ])
            ->all();
    }

    private function bookIssueHeaders(): array
    {
        return ['#', 'Book Title', 'ISBN', 'Issued To', 'Role', 'Issue Date', 'Due Date', 'Return Date', 'Status', 'Fine (PKR)', 'Notes'];
    }

    private function bookIssueRows(): array
    {
        return BookIssue::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['book', 'user'])
            ->orderByDesc('issue_date')
            ->get()
            ->values()
            ->map(fn ($issue, $i) => [
                $i + 1,
                $issue->book?->title ?? '',
                $issue->book?->isbn ?? '',
                $issue->user?->name ?? '',
                $issue->user?->role ?? '',
                $this->fmtDate($issue->issue_date),
                $this->fmtDate($issue->due_date),
                $this->fmtDate($issue->return_date),
                ucfirst($issue->status ?? ''),
                number_format((float) ($issue->fine_amount ?? 0), 2, '.', ''),
                $issue->notes ?? '',
            ])
            ->all();
    }

    private function otherHeaders(): array
    {
        return ['Category', 'Name / Title', 'Detail 1', 'Detail 2', 'Detail 3', 'Detail 4', 'Status'];
    }

    private function otherRows(): array
    {
        $rows = [];

        Classes::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->withCount('sections')
            ->orderBy('name')
            ->get()
            ->each(function ($class) use (&$rows) {
                $rows[] = ['Class', $class->name, 'Sections: ' . $class->sections_count, '', '', '', 'Active'];
            });

        Section::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with('class')
            ->orderBy('name')
            ->get()
            ->each(function ($section) use (&$rows) {
                $rows[] = ['Section', $section->name, 'Class: ' . ($section->class?->name ?? ''), 'Capacity: ' . ($section->capacity ?? ''), '', '', 'Active'];
            });

        InventoryItem::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderBy('name')
            ->get()
            ->each(function ($item) use (&$rows) {
                $status = $item->quantity <= 0 ? 'Out of Stock' : (($item->min_quantity && $item->quantity <= $item->min_quantity) ? 'Low' : 'In Stock');
                $rows[] = ['Inventory', $item->name, 'Category: ' . ($item->category ?? ''), 'Qty: ' . $item->quantity . ' ' . ($item->unit ?? ''), 'Location: ' . ($item->location ?? ''), 'Min: ' . ($item->min_quantity ?? ''), $status];
            });

        Book::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderBy('title')
            ->get()
            ->each(function ($book) use (&$rows) {
                $rows[] = ['Library Book', $book->title, 'Author: ' . ($book->author ?? ''), 'ISBN: ' . ($book->isbn ?? ''), 'Total: ' . $book->quantity, 'Available: ' . $book->available, 'Active'];
            });

        Notice::withoutGlobalScope('branch_id')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderByDesc('start_date')
            ->get()
            ->each(function ($notice) use (&$rows) {
                $rows[] = ['Notice', $notice->title, $this->fmtDate($notice->start_date) . ' – ' . $this->fmtDate($notice->end_date), Str($notice->content)->limit(80)->toString(), '', '', $notice->is_published ? 'Published' : 'Draft'];
            });

        return $rows;
    }
}
