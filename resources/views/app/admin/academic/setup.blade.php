<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-12">
                <h3 style="margin:0;"><i class="fa fa-graduation-cap"></i> Academic Setup</h3>
                <small class="text-muted">Follow these steps in order to configure your branch academics</small>
            </div>
        </div>

        <div class="row">
            @foreach($steps as $i => $step)
                <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px;">
                    <div class="white-box" style="min-height: 140px;">
                        <h4 style="margin:0 0 8px;">
                            <span class="label label-primary" style="margin-right:6px;">{{ $i + 1 }}</span>
                            <i class="fa {{ $step['icon'] }}"></i> {{ $step['title'] }}
                        </h4>
                        <p class="text-muted" style="font-size:13px; margin-bottom:12px;">{{ $step['desc'] }}</p>
                        <a href="{{ route($step['route']) }}" class="btn btn-primary btn-sm">Open</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-tenant-app-layout>
