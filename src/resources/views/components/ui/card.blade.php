@props(['title' => null, 'icon' => null, 'flush' => false])

<div {{ $attributes->class(['card']) }}>
    @if ($title || isset($actions))
        <div class="card-header d-flex align-items-center gap-2">
            @if ($icon)
                <i class="{{ $icon }} text-body-secondary"></i>
            @endif
            <div class="fw-semibold me-auto">{{ $title }}</div>
            {{ $actions ?? '' }}
        </div>
    @endif
    <div @class(['card-body' => !$flush])>
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer">{{ $footer }}</div>
    @endisset
</div>
