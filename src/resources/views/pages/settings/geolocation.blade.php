@php
    $zones = [['Kancelář', '#3b82f6', '50.1035', '14.4378', 150], ['Domov', '#22c55e', '50.0420', '14.4590', 100]];
    $zoneFields = [['label' => 'Název zóny (např. Kancelář)'], ['label' => 'Zeměpisná šířka (např. 50.0755)'], ['label' => 'Zeměpisná délka (např. 14.4378)'], ['label' => 'Rádius (m)', 'type' => 'number'], ['label' => 'Barva zóny', 'type' => 'color']];
@endphp
<x-ui.section title="Geolokace">
    <p class="small text-body-secondary">Jak často se sbírá poloha a co se z ní tvoří.</p>
    <x-ui.setting-row label="Přesnost">
        <select class="form-select">
            <option>Vysoká (GPS)</option>
            <option selected>Vyvážená</option>
            <option>Úsporná</option>
        </select>
    </x-ui.setting-row>
    <x-ui.setting-row label="Minimální posun (m)" help="Nový bod polohy se uloží jen po posunu o alespoň tuto vzdálenost. 0 = zaznamenat každý požadavek.">
        <input type="number" class="form-control" value="50">
    </x-ui.setting-row>
    <div class="d-flex justify-content-end mt-3"><button class="btn btn-primary btn-sm">Uložit nastavení polohy</button></div>
</x-ui.section>

<x-ui.section title="Zóny">
    <x-slot:actions>
        <x-ui.add-button label="Přidat" title="Přidat zónu" class="btn-sm" :fields="$zoneFields" />
    </x-slot:actions>
    <p class="small text-body-secondary">Pojmenovaná místa. Zaznamenané polohy se automaticky označí zónou, do jejíhož rádiusu spadají.</p>
    <div class="list-group list-flat">
        @foreach ($zones as [$name, $color, $lat, $lng, $radius])
            <div class="list-group-item d-flex align-items-center gap-3 py-2">
                <span class="rounded-circle flex-shrink-0" style="width: 12px; height: 12px; background: {{ $color }}"></span>
                <div class="fw-medium me-auto">{{ $name }}</div>
                <small class="font-mono text-body-secondary">{{ $lat }}, {{ $lng }}</small>
                <small class="font-mono text-body-secondary" style="width: 4rem">{{ $radius }} m</small>
                <x-boilerplate::dropdown>
                    <x-boilerplate::dropdown-item icon="fas fa-pen">Upravit</x-boilerplate::dropdown-item>
                    <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Odebrat</x-boilerplate::dropdown-item>
                </x-boilerplate::dropdown>
            </div>
        @endforeach
    </div>
</x-ui.section>
