<?php

namespace App\Services\Teacher;

use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;

class UpcomingClassService
{
    private const COUNTDOWN_THRESHOLD_HOURS = 23;

    private const DAY_ISO = [
        'Monday'    => 1,
        'Tuesday'   => 2,
        'Wednesday' => 3,
        'Thursday'  => 4,
        'Friday'    => 5,
        'Saturday'  => 6,
        'Sunday'    => 7,
    ];

    /**
     * Resolve the teacher's next class session (in progress or upcoming).
     *
     * @return array<string, mixed>|null
     */
    public function getNextForTeacher(User $teacher): ?array
    {
        $entries = TimeTable::with(['subject', 'class', 'section'])
            ->where('teacher_id', $teacher->id)
            ->where('is_break', false)
            ->whereNotNull('subject_id')
            ->when($teacher->branch_id, fn ($q) => $q->where('branch_id', $teacher->branch_id))
            ->get();

        if ($entries->isEmpty()) {
            return null;
        }

        $now = Carbon::now();
        $candidates = collect();

        foreach ($entries as $entry) {
            $occurrence = $this->resolveOccurrence($now, $entry);

            if ($occurrence) {
                $candidates->push($occurrence);
            }
        }

        if ($candidates->isEmpty()) {
            return null;
        }

        $next = $candidates->sortBy(fn ($item) => $item['sort_key'])->first();

        return $this->formatForDashboard($next, $now);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function resolveOccurrence(Carbon $now, TimeTable $entry): ?array
    {
        $dayOfWeek = $entry->day_of_week;
        if (! isset(self::DAY_ISO[$dayOfWeek])) {
            return null;
        }

        $startTime = Carbon::parse($entry->start_time);
        $endTime   = Carbon::parse($entry->end_time);

        $todayStart = $now->copy()->startOfDay()->setTime(
            $startTime->hour,
            $startTime->minute,
            $startTime->second
        );
        $todayEnd = $now->copy()->startOfDay()->setTime(
            $endTime->hour,
            $endTime->minute,
            $endTime->second
        );

        if ($now->dayOfWeekIso === self::DAY_ISO[$dayOfWeek]) {
            if ($now->gte($todayStart) && $now->lt($todayEnd)) {
                return $this->buildCandidate($entry, $todayStart, $todayEnd, 'in_progress');
            }
        }

        $nextStart = $this->resolveNextStart($now, $dayOfWeek, $startTime);
        $nextEnd   = $nextStart->copy()->startOfDay()->setTime(
            $endTime->hour,
            $endTime->minute,
            $endTime->second
        );

        if ($nextEnd->lte($nextStart)) {
            $nextEnd->addDay();
        }

        return $this->buildCandidate($entry, $nextStart, $nextEnd, 'upcoming');
    }

    private function resolveNextStart(Carbon $now, string $dayOfWeek, Carbon $startTime): Carbon
    {
        $targetDay = self::DAY_ISO[$dayOfWeek];
        $daysUntil = ($targetDay - $now->dayOfWeekIso + 7) % 7;

        $candidate = $now->copy()
            ->startOfDay()
            ->addDays($daysUntil)
            ->setTime($startTime->hour, $startTime->minute, $startTime->second);

        if ($candidate->lte($now)) {
            $candidate->addWeek();
        }

        return $candidate;
    }

    /**
     * @return array<string, mixed>
     */
    private function buildCandidate(
        TimeTable $entry,
        Carbon $startAt,
        Carbon $endAt,
        string $status
    ): array {
        return [
            'entry'    => $entry,
            'status'   => $status,
            'start_at' => $startAt,
            'end_at'   => $endAt,
            'sort_key' => $status === 'in_progress' ? 0 : $startAt->timestamp,
        ];
    }

    /**
     * @param  array<string, mixed>  $candidate
     * @return array<string, mixed>
     */
    private function formatForDashboard(array $candidate, Carbon $now): array
    {
        /** @var TimeTable $entry */
        $entry   = $candidate['entry'];
        $startAt = $candidate['start_at'];
        $endAt   = $candidate['end_at'];
        $status  = $candidate['status'];

        $secondsUntilStart = max(0, $startAt->timestamp - $now->timestamp);
        $secondsUntilEnd   = max(0, $endAt->timestamp - $now->timestamp);
        $thresholdSeconds  = self::COUNTDOWN_THRESHOLD_HOURS * 3600;

        $useCountdown = $status === 'in_progress'
            || $secondsUntilStart <= $thresholdSeconds;

        return [
            'status'              => $status,
            'class_name'          => $entry->class?->name ?? '—',
            'section_name'        => $entry->section?->name ?? '—',
            'subject_name'        => $entry->subject?->name ?? '—',
            'period_name'         => $entry->period_name,
            'room'                => $entry->room_number ?? '—',
            'start_at'            => $startAt->toIso8601String(),
            'end_at'              => $endAt->toIso8601String(),
            'start_formatted'     => $startAt->format('h:i A'),
            'end_formatted'       => $endAt->format('h:i A'),
            'date_formatted'      => $startAt->format('l, d M Y'),
            'datetime_formatted'  => $startAt->format('l, d M Y \a\t h:i A'),
            'display_mode'        => $useCountdown ? 'countdown' : 'datetime',
            'seconds_until_start' => $secondsUntilStart,
            'seconds_until_end'   => $secondsUntilEnd,
            'countdown_target'    => $status === 'in_progress' ? 'end' : 'start',
        ];
    }
}
