{{-- Flat page section: small uppercase title + actions, content without card chrome. --}}
@props(['title' => null, 'icon' => null])

<section {{ $attributes->class(['section']) }}>
    @if ($title || isset($actions))
        <div class="d-flex align-items-center gap-2 mb-2">
            <h2 class="section-title mb-0 me-auto">
                @if ($icon)<i class="{{ $icon }} me-1"></i>@endif{{ $title }}
            </h2>
            {{ $actions ?? '' }}
        </div>
    @endif
    {{ $slot }}
    @isset($footer)
        <div class="mt-2">{{ $footer }}</div>
    @endisset
</section>
