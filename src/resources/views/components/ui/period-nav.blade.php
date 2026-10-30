{{--
    Prev / Now / Next + date picker for time-based screens (Rozvrh, Výkazy…). Same controls everywhere.
    picker: "date" or "month" – the calendar button opens the native picker of that type.
--}}
@props(['label' => null, 'picker' => 'date', 'value' => null])

<div {{ $attributes->class(['d-flex align-items-center gap-2']) }} x-data>
    <div class="btn-group">
        <button type="button" class="btn btn-sm border" aria-label="{{ __('Předchozí') }}"><i class="fas fa-chevron-left fa-xs"></i></button>
        <button type="button" class="btn btn-sm border" aria-label="{{ __('Nyní') }}" title="{{ __('Nyní') }}">
            <span class="d-block rounded-circle bg-secondary" style="width: 6px; height: 6px"></span>
        </button>
        <button type="button" class="btn btn-sm border" aria-label="{{ __('Další') }}"><i class="fas fa-chevron-right fa-xs"></i></button>
    </div>
    <div class="position-relative">
        <button type="button" class="btn btn-sm border" aria-label="{{ __('Vybrat datum') }}" title="{{ __('Vybrat datum') }}"
            x-on:click="$refs.picker.showPicker?.() ?? $refs.picker.focus()">
            <i class="far fa-calendar"></i>
        </button>
        <input type="{{ $picker }}" x-ref="picker" value="{{ $value }}" tabindex="-1" aria-hidden="true"
            class="position-absolute start-0 bottom-0 opacity-0 pe-none" style="width: 1px; height: 1px">
    </div>
    @if ($label)
        <span class="fw-semibold text-nowrap small text-capitalize">{{ $label }}</span>
    @endif
</div>
