<x-tenant-app-layout>
    <x-slot name="header"></x-slot>
    <div class="container-fluid" style="margin-top:20px;">
        <h3 style="margin-bottom:15px;"><i class="fa fa-tachometer"></i> Teacher Dashboard</h3>
        <div class="row">
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-info" style="margin:0;">{{ $studentCount }}</h2><small>My Students</small></div></div>
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-primary" style="margin:0;">{{ $sectionCount }}</h2><small>Sections</small></div></div>
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-success" style="margin:0;">{{ $subjectCount }}</h2><small>Subjects</small></div></div>
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-warning" style="margin:0;">{{ $resultsEntered }}</h2><small>Results Entered</small></div></div>
        </div>
        <div class="row" style="margin-top:15px;">
            <div class="col-lg-12">
                <div class="white-box">
                    <h4>Quick Links</h4>
                    <a href="{{ route('teacher.attendance') }}" class="btn btn-primary btn-sm">Mark Attendance</a>
                    <a href="{{ route('teacher.exams.marks.index') }}" class="btn btn-success btn-sm">Enter Marks</a>
                    <a href="{{ route('teacher.students') }}" class="btn btn-default btn-sm">My Students</a>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
