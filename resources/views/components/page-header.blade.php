@props([
    'title',
    'addRoute'  => null,
    'addLabel'  => null,
    'addIcon'   => 'fa-plus',
    'backRoute' => null,
])

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="breadcome-list">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 0;">

            <h3 style="margin: 0;">{{ $title }}</h3>

            {{-- Back button: plain link, no dropdown --}}
            @if($backRoute)
                <a href="{{ $backRoute }}" class="btn btn-primary btn-sm" style="color: white;">
                    <i class="fa fa-arrow-left"></i> Back
                </a>

            {{-- Custom slot: multiple actions in 3-dot dropdown --}}
            @elseif($slot->isNotEmpty())
                <div class="dropdown-container" style="display: inline-block;">
                    <button class="dropdown-toggle-custom">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu-custom" style="left: auto; right: 0;">
                        {{ $slot }}
                    </div>
                </div>

            {{-- Single add button in 3-dot dropdown --}}
            @elseif($addRoute && $addLabel)
                <div class="dropdown-container" style="display: inline-block;">
                    <button class="dropdown-toggle-custom">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu-custom" style="left: auto; right: 0;">
                        <a href="{{ $addRoute }}" style="color: #333;">
                            <i class="fa {{ $addIcon }}"></i> {{ $addLabel }}
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
