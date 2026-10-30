{{-- One row of a list (mail, task, notification…). Leading visual: icon tile or avatar name. --}}
@props([
    'title',
    'subtitle' => null,
    'meta' => null,
    'icon' => null,
    'color' => 'secondary',
    'avatar' => null,
    'href' => null,
    'active' => false,
    'unread' => false,
])

<{{ $href ? 'a' : 'div' }} @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class(['list-group-item', 'list-group-item-action' => $href, 'active' => $active, 'd-flex gap-3 align-items-start py-3']) }}>
    @if ($avatar)
        <x-avatar :name="$avatar" size="sm" />
    @elseif ($icon)
        <x-boilerplate::icon-tile :icon="$icon" :color="$color" size="sm" />
    @endif
    <div class="flex-grow-1 min-w-0">
        <div class="d-flex align-items-center gap-2">
            @if ($unread)
                <span class="badge rounded-pill bg-primary p-1" aria-label="{{ __('Nepřečteno') }}"> </span>
            @endif
            <div @class(['text-truncate me-auto', 'fw-semibold' => $unread, 'fw-medium' => !$unread])>{{ $title }}</div>
            @if ($meta)
                <small class="text-body-secondary text-nowrap">{{ $meta }}</small>
            @endif
        </div>
        @if ($subtitle)
            <div class="small text-body-secondary text-truncate">{{ $subtitle }}</div>
        @endif
        {{ $slot }}
    </div>
    {{ $trailing ?? '' }}
</{{ $href ? 'a' : 'div' }}>
