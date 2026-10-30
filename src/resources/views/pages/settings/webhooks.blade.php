@php
    $events = [
        'work_report.created' => 'Výkaz práce – vytvoření', 'work_report.updated' => 'Výkaz práce – úprava', 'work_report.deleted' => 'Výkaz práce – smazání',
        'task.created' => 'Úkol – vytvoření', 'task.updated' => 'Úkol – úprava', 'task.deleted' => 'Úkol – smazání',
        'calendar_event.created' => 'Událost kalendáře – vytvoření', 'calendar_event.updated' => 'Událost kalendáře – úprava', 'calendar_event.deleted' => 'Událost kalendáře – smazání',
        'finance.target_reached' => 'Finance – měsíční cíl dosažen', 'finance.behind_pace' => 'Finance – pozadu za plánem',
    ];
    $webhookFields = [
        ['label' => 'Název (např. Zapier)'], ['label' => 'URL', 'type' => 'url'], ['label' => 'Secret pro podpis (nepovinné)', 'type' => 'password'],
        ['label' => 'Odesílané události', 'type' => 'checkboxes', 'options' => $events],
    ];
@endphp
<x-ui.section>
    <x-slot:actions>
        <x-ui.add-button label="Přidat" title="Přidat webhook" class="btn-sm" :fields="$webhookFields" />
    </x-slot:actions>
    <p class="small text-body-secondary">Při vybraných událostech se odešle HTTP POST s JSON payloadem na zadanou adresu (přes frontu).</p>
    <div class="list-group list-flat">
        <x-ui.list-item title="Zapier" subtitle="https://hooks.zapier.com/hooks/catch/123/abc" icon="fas fa-bolt">
            <div class="d-flex flex-wrap gap-1 mt-1">
                <x-badge color="secondary" variant="subtle" size="sm">Výkaz práce – vytvoření</x-badge>
                <x-badge color="secondary" variant="subtle" size="sm">Úkol – vytvoření</x-badge>
            </div>
            <x-slot:trailing>
                <div class="form-check form-switch mb-0"><input class="form-check-input" type="checkbox" checked aria-label="Aktivní"></div>
                <x-boilerplate::dropdown>
                    <x-boilerplate::dropdown-item icon="fas fa-pen">Upravit</x-boilerplate::dropdown-item>
                    <x-boilerplate::dropdown-item icon="fas fa-paper-plane">Odeslat test</x-boilerplate::dropdown-item>
                    <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Smazat</x-boilerplate::dropdown-item>
                </x-boilerplate::dropdown>
            </x-slot:trailing>
        </x-ui.list-item>
    </div>
</x-ui.section>
