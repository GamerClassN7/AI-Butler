{{-- Wireframe stand-in for content that will be built later (map, chart, editor…). --}}
@props(['label', 'icon' => 'fas fa-vector-square', 'height' => '12rem'])

<div {{ $attributes->class(['d-flex flex-column align-items-center justify-content-center text-body-tertiary border border-2 rounded-3 bg-body-tertiary']) }}
    style="border-style: dashed !important; min-height: {{ $height }}">
    <i class="{{ $icon }} fs-3 mb-2"></i>
    <small>{{ $label }}</small>
</div>
