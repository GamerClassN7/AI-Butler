@php
    $tasks = [
        ['Dopsat nabídku pro Acme', 'Acme s.r.o.', 'danger', 'Vysoká', 'po termínu', false],
        ['Nasadit AI-Butler wireframe', 'Interní', 'warning', 'Normální', 'dnes', false],
        ['Zaplatit fakturu 2026-118', 'Osobní', 'info', 'Normální', 'zítra', false],
        ['Objednat servis auta', 'Osobní', 'secondary', 'Nízká', 'pá', true],
    ];
@endphp
<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Úkoly">
            <x-boilerplate::nav-switch :options="['list' => ['label' => 'Seznam', 'icon' => 'fas fa-list'], 'board' => ['label' => 'Nástěnka', 'icon' => 'fas fa-table-columns']]" value="list" />
            <x-ui.add-button label="Úkol" title="Nový úkol" :fields="[
                ['label' => 'Název'], ['label' => 'Projekt', 'type' => 'select', 'options' => ['acme' => 'Acme s.r.o.', 'internal' => 'Interní', 'personal' => 'Osobní']],
                ['label' => 'Termín', 'type' => 'date'], ['label' => 'Priorita', 'type' => 'select', 'options' => ['high' => 'Vysoká', 'normal' => 'Normální', 'low' => 'Nízká']],
                ['label' => 'Popis', 'type' => 'textarea'],
            ]" />
        </x-ui.page-header>

        <x-ui.toolbar placeholder="Hledat úkol…">
            <select class="form-select w-auto"><option>Všechny projekty</option></select>
            <select class="form-select w-auto"><option>Otevřené</option><option>Hotové</option></select>
        </x-ui.toolbar>

        <x-ui.section>
            <div class="list-group list-flat">
                @foreach ($tasks as [$title, $project, $color, $priority, $due, $done])
                    <x-ui.list-item :title="$title" :subtitle="$project" :meta="$due" :icon="$done ? 'fas fa-circle-check' : 'far fa-circle'" :color="$done ? 'success' : 'secondary'" @class(['opacity-50' => $done])>
                        <x-slot:trailing>
                            <x-badge :color="$color" variant="subtle" size="sm">{{ $priority }}</x-badge>
                        </x-slot:trailing>
                    </x-ui.list-item>
                @endforeach
            </div>
        </x-ui.section>
    </div>
</x-layout-app>
