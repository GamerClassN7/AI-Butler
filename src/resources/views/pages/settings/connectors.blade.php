@use(App\Enums\ConnectorProvider)
@php
    // [provider, name, account, customer, error, enabled]
    $connectors = [
        [ConnectorProvider::Imap, 'Práce', 'prace@firma.cz', null, null, true],
        [ConnectorProvider::Gmail, 'Osobní', 'osobni@gmail.com', null, 'Token vypršel – znovu ověř účet', true],
        [ConnectorProvider::CalDav, 'Rodinný kalendář', 'caldav.seznam.cz', null, null, true],
        [ConnectorProvider::Ical, 'Acme Outlook', 'outlook.office365.com', 'ACME', null, false],
        [ConnectorProvider::Productive, 'Productive – hlavní účet', 'api.productive.io', null, null, true],
        [ConnectorProvider::Jira, 'Firemní Jira', 'firma.atlassian.net', 'ACME', null, true],
        [ConnectorProvider::BankStatements, 'Osobní účet', 'Fio banka · z účtu Osobní (Gmail)', null, null, true],
        [ConnectorProvider::BankNotices, 'Firemní účet', 'ČSOB · z účtu Práce', null, null, true],
    ];
@endphp
<x-ui.section title="Konektory">
    <x-slot:actions>
        <x-ui.add-button label="Přidat" title="Přidat konektor" class="btn-sm" :types="ConnectorProvider::pickerTypes()" />
    </x-slot:actions>
    <p class="small text-body-secondary">Odkud asistent čte poštu, kalendáře, úkoly, výkazy a bankovní výpisy. Citlivý účet se nikdy neposílá do AI.</p>
    <div class="list-group list-flat">
        @foreach ($connectors as [$provider, $name, $account, $customer, $error, $enabled])
            <x-ui.list-item :title="$name" :subtitle="$provider->label() . ' · ' . $account" :icon="$provider->icon()" :color="$error ? 'warning' : 'secondary'" @class(['opacity-50' => !$enabled])>
                <div class="d-flex flex-wrap gap-1 mt-1">
                    @foreach ($provider->capabilities() as $capability)
                        <x-badge color="secondary" variant="subtle" size="sm">{{ ConnectorProvider::capabilityLabels()[$capability] }}</x-badge>
                    @endforeach
                    @if ($customer)
                        <x-badge color="info" variant="subtle" size="sm" icon="fas fa-handshake">{{ $customer }}</x-badge>
                    @endif
                    @if ($error)
                        <x-badge color="warning" variant="subtle" size="sm" icon="fas fa-triangle-exclamation">{{ $error }}</x-badge>
                    @elseif (!$enabled)
                        <x-badge color="secondary" variant="subtle" size="sm">Vypnuto</x-badge>
                    @else
                        <x-badge color="success" variant="subtle" size="sm" icon="fas fa-check">Aktivní</x-badge>
                    @endif
                </div>
                <x-slot:trailing>
                    @if ($error)<button class="btn btn-sm btn-warning">Znovu ověřit</button>@endif
                    <div class="form-check form-switch mb-0" title="Aktivní"><input class="form-check-input" type="checkbox" @checked($enabled) aria-label="Aktivní"></div>
                    <x-boilerplate::dropdown>
                        <x-boilerplate::dropdown-item icon="fas fa-pen">Upravit</x-boilerplate::dropdown-item>
                        <x-boilerplate::dropdown-item icon="fas fa-plug-circle-check">Otestovat připojení</x-boilerplate::dropdown-item>
                        <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Odpojit</x-boilerplate::dropdown-item>
                    </x-boilerplate::dropdown>
                </x-slot:trailing>
            </x-ui.list-item>
        @endforeach
    </div>
</x-ui.section>
