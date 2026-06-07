<x-tenant-app-layout>
    <x-slot name="header"></x-slot>
    <div class="container-fluid" style="margin-top:20px;">
        <h3 style="margin-bottom:15px;"><i class="fa fa-calendar"></i> My Timetable</h3>
        <div class="white-box">
            @if($entries->isEmpty())
                <p class="text-muted text-center" style="padding:30px;">No timetable entries assigned to you.</p>
            @else
                @foreach($entries as $day => $slots)
                    <h4 style="margin-top:12px;">{{ $day }}</h4>
                    <table class="table table-bordered table-condensed">
                        <thead><tr><th>Period</th><th>Class</th><th>Section</th><th>Subject</th><th>Time</th><th>Room</th></tr></thead>
                        <tbody>
                            @foreach($slots as $slot)
                                <tr>
                                    <td>{{ $slot->period_name }}</td>
                                    <td>{{ $slot->class?->name }}</td>
                                    <td>{{ $slot->section?->name }}</td>
                                    <td>{{ $slot->is_break ? ($slot->break_name ?? 'Break') : ($slot->subject?->name ?? '—') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                                    <td>{{ $slot->room_number ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endif
        </div>
    </div>
</x-tenant-app-layout>
