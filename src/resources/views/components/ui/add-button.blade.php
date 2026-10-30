{{-- "Add" action – always opens a modal (boilerplate modal + wireframe form). --}}
@props(['label', 'title' => null, 'fields' => [], 'icon' => 'fas fa-plus', 'variant' => 'primary'])

<button type="button" {{ $attributes->class(['btn', 'btn-' . $variant]) }}
    x-on:click="Livewire.dispatch('openModal', { livewireComponents: 'wireframe.form', title: @js($title ?? $label), parameters: { fields: @js($fields) } })">
    <i class="{{ $icon }} me-1"></i> {{ $label }}
</button>
