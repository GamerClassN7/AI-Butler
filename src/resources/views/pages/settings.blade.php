@use(App\Enums\ConnectorProvider)
<x-layout-app>
    <div class="container-xl" style="max-width: 60rem">
        <x-ui.page-header title="Nastavení" />

        <x-boilerplate::tab.group default="connectors" query="tab">
            <x-boilerplate::tab.tabs>
                <x-boilerplate::tab.tab name="connectors">Konektory</x-boilerplate::tab.tab>
                <x-boilerplate::tab.tab name="ai">AI</x-boilerplate::tab.tab>
                <x-boilerplate::tab.tab name="notifications">Notifikace</x-boilerplate::tab.tab>
            </x-boilerplate::tab.tabs>

            <x-boilerplate::tab.panel name="connectors">
                @php
                    // [provider, name, account, error]
                    $connectors = [
                        [ConnectorProvider::Imap, 'Práce', 'prace@firma.cz', null],
                        [ConnectorProvider::Gmail, 'Osobní', 'osobni@gmail.com', 'Token vypršel – znovu ověř účet'],
                        [ConnectorProvider::CalDav, 'Rodinný kalendář', 'nextcloud.domov.cz', null],
                        [ConnectorProvider::Productive, 'Productive', 'firma.productive.io', null],
                    ];
                @endphp
                <x-ui.section class="mt-3">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <p class="text-body-secondary small mb-0 me-auto">Odkud asistent čte poštu, kalendáře, úkoly a výkazy.</p>
                        <x-ui.add-button label="Přidat konektor" title="Přidat konektor" class="btn-sm" :types="ConnectorProvider::pickerTypes()" />
                    </div>
                    <div class="list-group list-flat">
                        @foreach ($connectors as [$provider, $name, $account, $error])
                            <x-ui.list-item :title="$name" :subtitle="$provider->label() . ' · ' . $account" :icon="$provider->icon()" :color="$error ? 'warning' : 'secondary'">
                                <div class="d-flex flex-wrap gap-1 mt-1">
                                    @foreach ($provider->capabilities() as $capability)
                                        <x-badge color="secondary" variant="subtle" size="sm">{{ ConnectorProvider::capabilityLabels()[$capability] }}</x-badge>
                                    @endforeach
                                    @if ($error)
                                        <x-badge color="warning" variant="subtle" size="sm" icon="fas fa-triangle-exclamation">{{ $error }}</x-badge>
                                    @else
                                        <x-badge color="success" variant="subtle" size="sm" icon="fas fa-check">Ověřeno</x-badge>
                                    @endif
                                </div>
                                <x-slot:trailing>
                                    <div class="d-flex gap-1">
                                        @if ($error)<button class="btn btn-sm btn-warning">Ověřit</button>@endif
                                        <x-boilerplate::dropdown>
                                            <x-boilerplate::dropdown-item icon="fas fa-pen">Upravit</x-boilerplate::dropdown-item>
                                            <x-boilerplate::dropdown-item icon="fas fa-rotate">Synchronizovat</x-boilerplate::dropdown-item>
                                            <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Odpojit</x-boilerplate::dropdown-item>
                                        </x-boilerplate::dropdown>
                                    </div>
                                </x-slot:trailing>
                            </x-ui.list-item>
                        @endforeach
                    </div>
                </x-ui.section>
            </x-boilerplate::tab.panel>

            <x-boilerplate::tab.panel name="ai">
                <x-ui.section title="Poskytovatel AI" icon="fas fa-microchip" class="mt-3">
                    <label class="form-label">Poskytovatel</label>
                    <div class="row g-2 mb-4">
                        @foreach (['anthropic' => ['Anthropic', 'fas fa-asterisk'], 'openai' => ['OpenAI-kompatibilní', 'fas fa-plug'], 'ollama' => ['Ollama (lokálně)', 'fas fa-house-laptop']] as $key => [$label, $icon])
                            <div class="col-sm-4">
                                <input type="radio" class="btn-check" name="ai-provider" id="ai-{{ $key }}" @checked($loop->first)>
                                <label class="btn border w-100 h-100 d-flex align-items-center gap-2 p-3 text-start" for="ai-{{ $key }}">
                                    <x-boilerplate::icon-tile :icon="$icon" size="sm" /><span class="fw-semibold">{{ $label }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <x-form::input label="API klíč" type="password" group-class="mb-4" />
                    <x-form::select label="Model" :options="[]" placeholder="Nejdřív otestuj připojení" group-class="mb-4" />
                    <div class="d-flex gap-2 justify-content-end">
                        <button class="btn btn-light">Otestovat připojení</button>
                        <button class="btn btn-primary">Uložit</button>
                    </div>
                </x-ui.section>
            </x-boilerplate::tab.panel>

            <x-boilerplate::tab.panel name="notifications">
                {{-- No in-app notification centre – alerts go out by e-mail or push only. --}}
                <x-ui.section class="mt-3">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr><th>Událost</th><th class="text-center">E-mail</th><th class="text-center">Push</th></tr>
                            </thead>
                            <tbody>
                                @foreach (['Úkoly po termínu' => [1, 1], 'Nová důležitá pošta' => [0, 1], 'Chyby synchronizace' => [1, 0], 'Denní souhrn' => [1, 0]] as $label => [$mail, $push])
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td class="text-center"><input class="form-check-input" type="checkbox" @checked($mail) aria-label="{{ $label }} – e-mail"></td>
                                        <td class="text-center"><input class="form-check-input" type="checkbox" @checked($push) aria-label="{{ $label }} – push"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-ui.section>
            </x-boilerplate::tab.panel>
        </x-boilerplate::tab.group>
    </div>
</x-layout-app>
