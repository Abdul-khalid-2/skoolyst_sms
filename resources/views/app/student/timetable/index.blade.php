<x-tenant-app-layout>
    <x-slot name="header"></x-slot>
    <div class="container-fluid" style="margin-top:20px;">
        <h3 style="margin-bottom:15px;"><i class="fa fa-calendar"></i> My Timetable</h3>
        @if(!$profile)
            <div class="white-box"><p class="text-muted text-center">Class/section not assigned.</p></div>
        @elseif($entries->isEmpty())
            <div class="white-box"><p class="text-muted text-center">No timetable published yet.</p></div>
        @else
            <div class="white-box">
                <p><strong>Class:</strong> {{ $profile->class?->name }} &nbsp; <strong>Section:</strong> {{ $profile->section?->name }}</p>
                @foreach($entries as $day => $slots)
                    <h4>{{ $day }}</h4>
                    <table class="table table-bordered">
                        <thead><tr><th>Period</th><th>Subject</th><th>Teacher</th><th>Time</th><th>Room</th></tr></thead>
                        <tbody>
                            @foreach($slots as $slot)
                                <tr>
                                    <td>{{ $slot->period_name }}</td>
                                    <td>{{ $slot->is_break ? ($slot->break_name ?? 'Break') : ($slot->subject?->name ?? '—') }}</td>
                                    <td>{{ $slot->is_break ? '—' : ($slot->teacher?->name ?? '—') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                                    <td>{{ $slot->room_number ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        @endif
    </div>
</x-tenant-app-layout>
