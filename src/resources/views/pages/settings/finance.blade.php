@php
    $categories = [['Potraviny', '#22c55e', 42], ['Bydlení', '#3b82f6', 6], ['Doprava', '#f59e0b', 18], ['Předplatné', '#a855f7', 9], ['Restaurace', '#ef4444', 23]];
    $rules = [['Albert', 'merchant', 'Potraviny', 'ai'], ['CZ65 0800 0000 1920 0014 5399', 'account', 'Bydlení', 'manual'], ['Netflix', 'merchant', 'Předplatné', 'manual']];
    $categoryFields = [['label' => 'Název'], ['label' => 'Barva v grafech', 'type' => 'color']];
@endphp
<x-ui.section title="Finanční cíl">
    <x-ui.setting-row label="Cílová částka za měsíc (Kč)" help="Podle pracovního fondu (pracovní dny minus svátky) se spočítá tempo na stránce Výkazy. Při dosažení cíle a při zaostávání přijde notifikace.">
        <div class="d-flex gap-2">
            <input type="number" class="form-control" placeholder="Nepovinné" value="250000">
            <button class="btn btn-primary">Uložit</button>
        </div>
    </x-ui.setting-row>
</x-ui.section>

<x-ui.section title="Kategorie plateb">
    <x-slot:actions>
        <x-ui.add-button label="Přidat" title="Nová kategorie" class="btn-sm" :fields="$categoryFields" />
    </x-slot:actions>
    <p class="small text-body-secondary">Do čeho se řadí odchozí platby na stránce Útrata.</p>
    <div class="list-group list-flat">
        @foreach ($categories as [$name, $color, $count])
            <div class="list-group-item d-flex align-items-center gap-3 py-2">
                <span class="rounded-1 flex-shrink-0" style="width: 12px; height: 12px; background: {{ $color }}"></span>
                <div class="fw-medium me-auto">{{ $name }}</div>
                <small class="text-body-secondary">{{ $count }} plateb</small>
                <x-boilerplate::dropdown>
                    <x-boilerplate::dropdown-item icon="fas fa-pen">Upravit</x-boilerplate::dropdown-item>
                    <x-boilerplate::dropdown-item icon="fas fa-code-merge">Sloučit do…</x-boilerplate::dropdown-item>
                    <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Odebrat</x-boilerplate::dropdown-item>
                </x-boilerplate::dropdown>
            </div>
        @endforeach
    </div>
</x-ui.section>

<x-ui.section title="Pravidla kategorií">
    <p class="small text-body-secondary">Vznikají při zařazení platby s volbou „pro všechny platby“ nebo potvrzením návrhu AI.</p>
    <div class="list-group list-flat">
        @foreach ($rules as [$label, $matchType, $category, $origin])
            <div class="list-group-item d-flex align-items-center gap-2 py-2">
                <x-badge color="secondary" variant="subtle" size="sm">{{ $matchType === 'account' ? 'Účet' : 'Obchodník' }}</x-badge>
                <div class="text-truncate {{ $matchType === 'account' ? 'font-mono small' : 'fw-medium' }}">{{ $label }}</div>
                <i class="fas fa-arrow-right small text-body-tertiary"></i>
                <div class="me-auto">{{ $category }}</div>
                <x-badge :color="$origin === 'ai' ? 'primary' : 'secondary'" variant="subtle" size="sm" :title="$origin === 'ai' ? 'Potvrzený návrh AI' : 'Zařazeno ručně'">{{ $origin === 'ai' ? 'AI' : 'ručně' }}</x-badge>
                <x-boilerplate::dropdown>
                    <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Smazat pravidlo</x-boilerplate::dropdown-item>
                </x-boilerplate::dropdown>
            </div>
        @endforeach
    </div>
</x-ui.section>
