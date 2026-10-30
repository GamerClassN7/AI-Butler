{{-- One settings row: label + help on the left, control on the right (stacked below md). --}}
@props(['label', 'help' => null])

<div {{ $attributes->class(['row g-2 py-3 border-bottom align-items-center']) }}>
    <div class="col-md-5">
        <div class="fw-medium">{{ $label }}</div>
        @if ($help)
            <div class="small text-body-secondary">{{ $help }}</div>
        @endif
    </div>
    <div class="col-md-7">{{ $slot }}</div>
</div>
