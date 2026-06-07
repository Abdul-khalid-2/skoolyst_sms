<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-bullhorn"></i> Notices
                </h3>
                <small class="text-muted">School announcements for parents</small>
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
                    @if($notices->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:12px;"></i>
                            No notices at the moment.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Content</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notices as $notice)
                                        <tr>
                                            <td><strong>{{ $notice->title }}</strong></td>
                                            <td>
                                                {{ $notice->start_date ? \Carbon\Carbon::parse($notice->start_date)->format('d M Y') : '—' }}
                                                @if($notice->end_date)
                                                    <br><small class="text-muted">Until {{ \Carbon\Carbon::parse($notice->end_date)->format('d M Y') }}</small>
                                                @endif
                                            </td>
                                            <td>{!! nl2br(e(strip_tags($notice->content))) !!}</td>
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
