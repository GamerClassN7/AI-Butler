@php
    // Configured providers (see AI modely) – picked by tiles, never a select.
    $providers = [
        'claude' => ['label' => 'Anthropic Claude', 'icon' => 'fas fa-asterisk', 'models' => ['claude-sonnet-5-5' => 'claude-sonnet-5-5', 'claude-haiku-5-5' => 'claude-haiku-5-5']],
        'compatible' => ['label' => 'Ollama (lokálně)', 'icon' => 'fas fa-house-laptop', 'models' => ['qwen3:14b' => 'qwen3:14b', 'bge-m3' => 'bge-m3']],
        'openai' => ['label' => 'OpenAI (GPT)', 'icon' => 'fas fa-circle-nodes', 'disabled' => true],
        'gemini' => ['label' => 'Google Gemini', 'icon' => 'fab fa-google', 'disabled' => true],
    ];
    $pickerTypes = function (bool $withDefault, array $extraFields = []) use ($providers) {
        $types = $withDefault ? ['default' => ['label' => 'Podle hlavního agenta', 'icon' => 'fas fa-arrow-turn-up', 'description' => 'Bez výjimky', 'fields' => [['label' => 'Úloha použije hlavního agenta.', 'type' => 'note']]]] : [];
        foreach ($providers as $key => $provider) {
            $types[$key] = [
                'label' => $provider['label'],
                'icon' => $provider['icon'],
                'disabled' => $provider['disabled'] ?? false,
                'description' => ($provider['disabled'] ?? false) ? null : 'Nastaveno',
                'fields' => [['label' => 'Model', 'type' => 'select', 'options' => $provider['models'] ?? []], ...$extraFields],
            ];
        }

        return $types;
    };

    // [label, description, provider key|null (= main agent), model, extra modal fields]
    $jobs = [
        ['Převod e-mailů a feedu', 'Z e-mailu udělá úkol nebo událost; z e-mailu i článku navrhne zápis do znalostí.', null, null, []],
        ['Zpřesňování znalostí', 'Optimalizace a návrhy spojnic mezi koncepty.', null, null, []],
        ['Dělení a slučování konceptů', 'Rozdělí příliš obecný koncept nebo sloučí duplicity.', null, null, []],
        ['Denní tip ke čtení', 'Ráno vybere jednu nepřečtenou položku z feedu, kterou stojí za to si přečíst.', 'compatible', 'qwen3:14b', []],
        ['Auto-tagování feedu', 'Navrhuje štítky pro nové i staré netagované položky feedu.', 'compatible', 'qwen3:14b', []],
        ['Kategorie plateb', 'Navrhuje kategorie karetních plateb. Odchází jen anonymizovaný název obchodníka – žádné účty ani částky.', null, null, []],
        ['Embeddingy (sémantické vyhledávání)', 'Převádí znalosti na vektory pro vyhledávání podle významu. Doporučeno lokálně: Ollama + bge-m3 (umí česky).', 'compatible', 'bge-m3',
            [['label' => 'Prefix dotazu (jen e5 / nomic, např. „query: “)'], ['label' => 'Prefix dokumentu (např. „passage: “)']]],
    ];
@endphp
<x-ui.section>
    <p class="small text-body-secondary">Úloha bez výjimky použije hlavního agenta.</p>

    <div class="panel d-flex align-items-center gap-3 p-3 mb-3">
        <x-boilerplate::icon-tile icon="fas fa-asterisk" color="primary" />
        <div class="me-auto min-w-0">
            <div class="fw-semibold">Hlavní agent</div>
            <div class="small text-body-secondary">Anthropic Claude · <span class="font-mono">claude-sonnet-5-5</span></div>
        </div>
        <x-ui.add-button label="Změnit" title="Hlavní agent" icon="fas fa-pen" variant="light" class="btn-sm" :types="$pickerTypes(false)" />
    </div>

    <div class="list-group list-flat">
        @foreach ($jobs as [$label, $description, $providerKey, $model, $extraFields])
            <x-ui.list-item :title="$label" :subtitle="null">
                <div class="small text-body-secondary text-wrap">{{ $description }}</div>
                @if ($label === 'Auto-tagování feedu')
                    <div class="form-check form-switch mt-1 mb-0">
                        <input class="form-check-input" type="checkbox" id="allow-new-tags">
                        <label class="form-check-label small" for="allow-new-tags">Umožnit vytvářet nové štítky</label>
                    </div>
                @endif
                <x-slot:trailing>
                    @if ($providerKey)
                        <x-badge color="primary" variant="subtle" :icon="$providers[$providerKey]['icon']" class="text-nowrap">
                            {{ $providers[$providerKey]['label'] }} · <span class="font-mono">{{ $model }}</span>
                        </x-badge>
                    @else
                        <x-badge color="secondary" variant="subtle" icon="fas fa-arrow-turn-up" class="text-nowrap">Hlavní agent</x-badge>
                    @endif
                    <x-ui.add-button label="" :title="$label" icon="fas fa-pen" variant="light" class="btn-sm" aria-label="Změnit model úlohy" :types="$pickerTypes(true, $extraFields)" />
                </x-slot:trailing>
            </x-ui.list-item>
        @endforeach
    </div>
</x-ui.section>
