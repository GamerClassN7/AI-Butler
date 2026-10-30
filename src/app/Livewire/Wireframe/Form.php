<?php

namespace App\Livewire\Wireframe;

use Livewire\Component;
use SteelAnts\LaravelBoilerplate\Attributes\AllowInModal;

/**
 * Generic modal form for the wireframe phase – renders the given fields, saves nothing.
 * Field: ['label' => 'Název', 'type' => 'text|textarea|select|date|time|email|number', 'options' => [...]].
 * Replace with a real Livewire FormComponent per module once logic exists.
 */
#[AllowInModal]
class Form extends Component
{
    public array $fields = [];

    public function store()
    {
        $this->dispatch('closeModal');
        alert()->info(__('Wireframe – zatím se nic neukládá.'))->now();
    }

    public function render()
    {
        return view('livewire.wireframe.form');
    }
}
