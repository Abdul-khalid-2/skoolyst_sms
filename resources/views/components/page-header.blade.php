@props([
    'title',
    'addRoute'  => null,
    'addLabel'  => null,
    'addIcon'   => 'fa-plus',
    'backRoute' => null,
])

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="breadcome-list">
        <div class="page-header-bar">

            <h3 class="page-header-title">{{ $title }}</h3>

            {{-- Back button: always visible as a plain button --}}
            @if($backRoute)
                <a href="{{ $backRoute }}" class="btn btn-primary btn-sm page-header-back-btn" style="color: white;">
                    <i class="fa fa-arrow-left"></i> Back
                </a>

            {{-- Custom slot: buttons on desktop, 3-dot dropdown on mobile --}}
            @elseif($slot->isNotEmpty())
                <div class="page-header-actions dropdown-container">
                    <button type="button" class="dropdown-toggle-custom" aria-label="More actions">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu-custom page-header-dropdown-menu">
                        {{ $slot }}
                    </div>
                </div>

            {{-- Single add action: button on desktop, 3-dot dropdown on mobile --}}
            @elseif($addRoute && $addLabel)
                <div class="page-header-actions dropdown-container">
                    <button type="button" class="dropdown-toggle-custom" aria-label="More actions">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu-custom page-header-dropdown-menu">
                        <a href="{{ $addRoute }}" style="color: #333;">
                            <i class="fa {{ $addIcon }}"></i> {{ $addLabel }}
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
