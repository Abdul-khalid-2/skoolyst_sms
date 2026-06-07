<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-12">
                <div class="white-box" style="display:flex; align-items:center; gap:18px; flex-wrap:wrap;">
                    <div>
                        <h3 style="margin:0;">Welcome, {{ $parent->name }}!</h3>
                        <small class="text-muted">Parent Panel &middot; {{ $stats['children_count'] }} linked child(ren)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="analytics-sparkle-area">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('parent.children') }}" style="text-decoration:none;">
                        <div class="white-box text-center">
                            <h5 class="text-muted" style="margin-top:0;">Children</h5>
                            <h2 class="text-primary" style="margin:6px 0;">{{ $stats['children_count'] }}</h2>
                            <small class="text-muted">Linked students</small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="white-box text-center">
                        <h5 class="text-muted" style="margin-top:0;">Attendance</h5>
                        <h2 class="text-info" style="margin:6px 0;">{{ $stats['attendance']['percentage'] }}%</h2>
                        <small class="text-muted">Across all children</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('parent.fees') }}" style="text-decoration:none;">
                        <div class="white-box text-center">
                            <h5 class="text-muted" style="margin-top:0;">Fee Outstanding</h5>
                            <h2 class="{{ $stats['fees']['outstanding'] > 0 ? 'text-danger' : 'text-success' }}" style="margin:6px 0;">
                                {{ $currency }}{{ number_format($stats['fees']['outstanding'], 0) }}
                            </h2>
                            <small class="text-muted">
                                @if($stats['fees']['overdue'] > 0) {{ $stats['fees']['overdue'] }} overdue @else All clear @endif
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('parent.books') }}" style="text-decoration:none;">
                        <div class="white-box text-center">
                            <h5 class="text-muted" style="margin-top:0;">Books Issued</h5>
                            <h2 class="text-info" style="margin:6px 0;">{{ $stats['books']['active'] }}</h2>
                            <small class="text-muted">
                                @if($stats['books']['overdue'] > 0) <span class="text-danger">{{ $stats['books']['overdue'] }} overdue</span> @else On loan @endif
                            </small>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-child"></i> My Children</h3>
                    @if($children->isEmpty())
                        <p class="text-muted text-center" style="padding: 25px 0;">No children linked to your account.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($children as $child)
                                        @php
                                            $profile = $child->studentProfile;
                                            $className = $profile->class->name ?? '—';
                                            $sectionName = $profile->section->name ?? '—';
                                        @endphp
                                        <tr>
                                            <td>{{ $child->name }}</td>
                                            <td>{{ $className }} ({{ $sectionName }})</td>
                                            <td class="text-right">
                                                <a href="{{ route('parent.children.attendance', $child->id) }}" class="btn btn-default btn-xs">Attendance</a>
                                                <a href="{{ route('parent.children.results', $child->id) }}" class="btn btn-primary btn-xs">Results</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-bullhorn"></i> Notice Board</h3>
                    @if($notices->isEmpty())
                        <p class="text-muted text-center" style="padding: 25px 0;">No notices at the moment.</p>
                    @else
                        <ul class="list-unstyled" style="margin-bottom:0;">
                            @foreach($notices as $notice)
                                <li style="padding:10px 0; border-bottom:1px solid #f0f0f0;">
                                    <strong>{{ $notice->title }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $notice->start_date ? \Carbon\Carbon::parse($notice->start_date)->format('d M Y') : '' }}
                                    </small>
                                    <p style="margin:4px 0 0; color:#666; font-size:13px;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($notice->content), 90) }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                        <div style="margin-top:12px;">
                            <a href="{{ route('parent.notices') }}" class="btn btn-default btn-sm">View All Notices</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
