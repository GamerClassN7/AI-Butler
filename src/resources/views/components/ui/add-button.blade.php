{{-- "Add" action – always opens a modal (boilerplate modal + wireframe form). Pass :types for a pick-type-first flow. --}}
@props(['label', 'title' => null, 'fields' => [], 'types' => [], 'icon' => 'fas fa-plus', 'variant' => 'primary'])

<button type="button" {{ $attributes->class(['btn', 'btn-' . $variant]) }}
    x-on:click="Livewire.dispatch('openModal', { livewireComponents: 'wireframe.form', title: @js($title ?? $label), parameters: { fields: @js($fields), types: @js($types) } })">
    <i @class([$icon, 'me-1' => $label])></i>{{ $label }}
</button>
