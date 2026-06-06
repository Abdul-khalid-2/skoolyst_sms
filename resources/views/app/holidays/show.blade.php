<x-tenant-app-layout>
    @push('css')
        <style>
            .info-box { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .info-box h4 { margin:0 0 12px; font-size:15px; font-weight:700; border-bottom:1px solid #f0f0f0; padding-bottom:8px; }
            .info-row { display:flex; justify-content:space-between; padding:7px 0; border-bottom:1px solid #f8f8f8; font-size:13px; }
            .info-row:last-child { border-bottom:none; }
            .info-row span:first-child { color:#888; }
            .info-row span:last-child  { font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="{{ $holiday->title }}">
                <a href="{{ route('holidays.edit', $holiday) }}" style="color:#333;"><i class="fa fa-edit"></i> Edit Holiday</a>
                <a href="{{ route('holidays.index') }}" style="color:#333;"><i class="fa fa-list"></i> All Holidays</a>
            </x-page-header>

            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <div class="info-box">
                    <h4><i class="fa fa-calendar"></i> Holiday Details</h4>
                    @php
                        $today = now()->format('Y-m-d');
                        $start = \Carbon\Carbon::parse($holiday->start_date);
                        $end   = \Carbon\Carbon::parse($holiday->end_date);
                        $days  = $start->diffInDays($end) + 1;
                        if ($holiday->end_date < $today) {
                            $state = ['default', 'Past'];
                        } elseif ($holiday->start_date > $today) {
                            $state = ['info', 'Upcoming'];
                        } else {
                            $state = ['warning', 'Ongoing'];
                        }
                    @endphp
                    <div class="info-row"><span>Title</span><span>{{ $holiday->title }}</span></div>
                    <div class="info-row"><span>Start Date</span><span>{{ $start->format('d M Y (l)') }}</span></div>
                    <div class="info-row"><span>End Date</span><span>{{ $end->format('d M Y (l)') }}</span></div>
                    <div class="info-row"><span>Duration</span><span>{{ $days }} {{ \Illuminate\Support\Str::plural('day', $days) }}</span></div>
                    <div class="info-row">
                        <span>Type</span>
                        <span>
                            @if($holiday->is_recurring)
                                <span class="label label-primary">Recurring ({{ ucfirst($holiday->recurring_pattern ?? 'n/a') }})</span>
                            @else
                                <span class="label label-default">One-time</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span>Status</span>
                        <span><span class="label label-{{ $state[0] }}">{{ $state[1] }}</span></span>
                    </div>
                    @if($holiday->description)
                        <div style="margin-top:14px; font-size:13px; color:#666; line-height:1.6;">
                            {{ $holiday->description }}
                        </div>
                    @endif
                </div>

                <div style="display:flex; gap:10px;">
                    <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('holidays.destroy', $holiday) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this holiday?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>
