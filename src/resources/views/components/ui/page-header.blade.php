{{-- Page title row used on every screen. Primary action goes into the default slot. --}}
@props(['title', 'subtitle' => null, 'breadcrumb' => []])

<div {{ $attributes->class(['page-header']) }}>
    <div class="me-auto">
        {{-- Own markup: x-boilerplate::breadcrumb (v3.1) crashes – its class and view disagree on the items shape. --}}
        @if ($breadcrumb)
            <nav aria-label="{{ __('Breadcrumb') }}">
                <ol class="breadcrumb small mb-1">
                    @foreach ($breadcrumb as $path => $label)
                        @if ($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ url($path) }}">{{ $label }}</a></li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
        <h1>{{ $title }}</h1>
        @if ($subtitle)
            <div class="text-body-secondary small">{{ $subtitle }}</div>
        @endif
    </div>
    @if ($slot->isNotEmpty())
        <div class="d-flex flex-wrap align-items-center gap-2">{{ $slot }}</div>
    @endif
</div>
