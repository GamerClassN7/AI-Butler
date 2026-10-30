@php
    $customers = [
        ['ACME', '#fdba74', 15, 1200],
        ['BETA', '#6ee7b7', 5, 1100],
        ['INT', '#c4b5fd', null, null],
    ];
    $customerFields = [['label' => 'Název zákazníka'], ['label' => 'Barva v přehledu', 'type' => 'color'], ['label' => 'Limit MD/měs. (nepovinné)', 'type' => 'number'], ['label' => 'Hodinová sazba (nepovinné)', 'type' => 'number']];
@endphp
<x-ui.section title="Pracovní doba">
    <x-ui.setting-row label="Pracovní dny" help="Mimo pracovní dny a hodiny je rozvrh ztlumený.">
        <div class="d-flex flex-wrap gap-1">
            @foreach (['Po', 'Út', 'St', 'Čt', 'Pá', 'So', 'Ne'] as $i => $day)
                <input type="checkbox" class="btn-check" id="wd-{{ $i }}" @checked($i < 5)>
                <label class="btn btn-sm btn-outline-secondary" style="min-width: 2.75rem" for="wd-{{ $i }}">{{ $day }}</label>
            @endforeach
        </div>
    </x-ui.setting-row>
    <x-ui.setting-row label="Začátek a konec" help="Délka pracovní doby = 1 MD (man-day) pro limity zákazníků.">
        <div class="d-flex align-items-center gap-2">
            <input type="time" class="form-control w-auto" value="08:00" aria-label="Začátek">
            <span class="text-body-secondary">–</span>
            <input type="time" class="form-control w-auto" value="16:30" aria-label="Konec">
        </div>
    </x-ui.setting-row>
    <div class="d-flex justify-content-end mt-3"><button class="btn btn-primary btn-sm">Uložit</button></div>
</x-ui.section>

<x-ui.section title="Zákazníci">
    <x-slot:actions>
        <x-ui.add-button label="Přidat" title="Přidat zákazníka" class="btn-sm" :fields="$customerFields" />
    </x-slot:actions>
    <p class="small text-body-secondary">Výběr u ručních výkazů. Limit v MD je nepovinný – na stránce Výkazy se pak zobrazí čerpání za měsíc.</p>
    <div class="list-group list-flat">
        @foreach ($customers as [$name, $color, $mdLimit, $rate])
            <div class="list-group-item d-flex align-items-center gap-3 py-3">
                <span class="rounded-1 flex-shrink-0" style="width: 12px; height: 12px; background: {{ $color }}"></span>
                <div class="fw-semibold me-auto">{{ $name }}</div>
                <div class="text-end small" style="width: 6rem">
                    <div class="text-body-secondary" style="font-size: 11px">MD/měs.</div>
                    <div class="font-mono">{{ $mdLimit ?? '—' }}</div>
                </div>
                <div class="text-end small" style="width: 7rem">
                    <div class="text-body-secondary" style="font-size: 11px">Hodinová sazba</div>
                    <div class="font-mono">{{ $rate ? number_format($rate, 0, ',', ' ') . ' Kč' : '—' }}</div>
                </div>
                <x-boilerplate::dropdown>
                    <x-boilerplate::dropdown-item icon="fas fa-pen">Upravit</x-boilerplate::dropdown-item>
                    <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Smazat</x-boilerplate::dropdown-item>
                </x-boilerplate::dropdown>
            </div>
        @endforeach
    </div>
</x-ui.section>
