{{-- Search + filters row above lists. Filters go into the default slot. --}}
@props(['placeholder' => __('Hledat…')])

<div {{ $attributes->class(['d-flex flex-wrap align-items-center gap-2 mb-3']) }}>
    <div class="input-group flex-grow-1" style="max-width: 24rem">
        <span class="input-group-text"><i class="fas fa-magnifying-glass"></i></span>
        <input type="search" class="form-control" placeholder="{{ $placeholder }}">
    </div>
    {{ $slot }}
</div>
