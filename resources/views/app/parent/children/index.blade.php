<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-child"></i> My Children
                </h3>
                <small class="text-muted">Students linked to your parent account</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    @if($children->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:12px;"></i>
                            No children are linked to your account yet.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Admission No</th>
                                        <th>Relationship</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($children as $index => $child)
                                        @php $profile = $child->studentProfile; @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $child->name }}</td>
                                            <td>
                                                {{ $profile->class->name ?? '—' }}
                                                ({{ $profile->section->name ?? '—' }})
                                            </td>
                                            <td>{{ $profile->admission_no ?? '—' }}</td>
                                            <td>{{ ucfirst($child->pivot->relationship ?? '—') }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('parent.children.attendance', $child->id) }}" class="btn btn-default btn-sm">
                                                    <i class="fa fa-calendar-check-o"></i> Attendance
                                                </a>
                                                <a href="{{ route('parent.children.results', $child->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-trophy"></i> Results
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
