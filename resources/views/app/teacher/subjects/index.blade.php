<x-tenant-app-layout>
    <x-slot name="header"></x-slot>
    <div class="container-fluid" style="margin-top:20px;">
        <h3 style="margin-bottom:15px;"><i class="fa fa-flask"></i> My Subjects</h3>
        <div class="white-box">
            @if($allocations->isEmpty())
                <p class="text-muted text-center" style="padding:30px;">No subject allocations yet.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead><tr><th>Class</th><th>Section</th><th>Subject</th></tr></thead>
                    <tbody>
                        @foreach($allocations as $row)
                            <tr>
                                <td>{{ $row->section?->class?->name ?? '—' }}</td>
                                <td>{{ $row->section?->name ?? '—' }}</td>
                                <td>{{ $row->subject?->name ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-tenant-app-layout>
