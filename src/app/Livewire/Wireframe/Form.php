<?php

namespace App\Livewire\Wireframe;

use Livewire\Component;
use SteelAnts\LaravelBoilerplate\Attributes\AllowInModal;

/**
 * Generic modal form for the wireframe phase – renders the given fields, saves nothing.
 * Field: ['label' => 'Název', 'type' => 'text|textarea|select|checkboxes|note|color|date|time|datetime-local|email|number|password', 'options' => [...]].
 * Types (optional): ['imap' => ['label' => 'IMAP', 'icon' => 'fas fa-server', 'description' => '…', 'disabled' => false, 'fields' => [...]]]
 * – step 1 picks a type from clickable tiles, step 2 shows that type's fields. Never use a select for the type.
 * Replace with a real Livewire FormComponent per module once logic exists.
 */
#[AllowInModal]
class Form extends Component
{
    public array $fields = [];

    public array $types = [];

    public ?string $type = null;

    public function pickType(string $type)
    {
        if (isset($this->types[$type]) && empty($this->types[$type]['disabled'])) {
            $this->type = $type;
        }
    }

    public function resetType()
    {
        $this->type = null;
    }

    public function store()
    {
        $this->dispatch('closeModal');
        alert()->info(__('Wireframe – zatím se nic neukládá.'))->now();
    }

    public function render()
    {
        return view('livewire.wireframe.form', [
            'activeFields' => $this->type ? ($this->types[$this->type]['fields'] ?? []) : $this->fields,
        ]);
    }
}
