{{-- Page title row used on every screen. Primary action goes into the default slot. --}}
@props(['title', 'subtitle' => null, 'breadcrumb' => []])

<div {{ $attributes->class(['page-header']) }}>
    <div class="me-auto">
        <x-boilerplate::breadcrumb :items="$breadcrumb" class="small mb-1" />
        <h1>{{ $title }}</h1>
        @if ($subtitle)
            <div class="text-body-secondary small">{{ $subtitle }}</div>
        @endif
    </div>
    @if ($slot->isNotEmpty())
        <div class="d-flex flex-wrap align-items-center gap-2">{{ $slot }}</div>
    @endif
</div>
