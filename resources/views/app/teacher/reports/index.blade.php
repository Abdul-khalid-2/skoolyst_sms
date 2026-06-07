<x-tenant-app-layout>
    <x-slot name="header"></x-slot>
    <div class="container-fluid" style="margin-top:20px;">
        <h3 style="margin-bottom:15px;"><i class="fa fa-bar-chart"></i> My Reports</h3>
        <div class="white-box">
            @if(empty($classStats))
                <p class="text-muted text-center" style="padding:30px;">No report data available.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead><tr><th>Class</th><th>Students</th><th>Attendance %</th><th>Results Entered</th></tr></thead>
                    <tbody>
                        @foreach($classStats as $stat)
                            <tr>
                                <td>{{ $stat['class'] }}</td>
                                <td>{{ $stat['students'] }}</td>
                                <td>{{ $stat['attendance'] }}%</td>
                                <td>{{ $stat['results'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-tenant-app-layout>
