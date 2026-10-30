@php
    $providerOptions = ['' => '— Podle hlavního agenta —', 'claude' => 'Anthropic Claude', 'compatible' => 'OpenAI-kompatibilní'];
    $jobs = [
        ['Převod e-mailů a feedu', 'Z e-mailu udělá úkol nebo událost; z e-mailu i článku navrhne zápis do znalostí.'],
        ['Zpřesňování znalostí', 'Optimalizace a návrhy spojnic mezi koncepty.'],
        ['Dělení a slučování konceptů', 'Rozdělí příliš obecný koncept nebo sloučí duplicity.'],
        ['Denní tip ke čtení', 'Ráno vybere jednu nepřečtenou položku z feedu, kterou stojí za to si přečíst.'],
        ['Auto-tagování feedu', 'Navrhuje štítky pro nové i staré netagované položky feedu.'],
        ['Kategorie plateb', 'Navrhuje kategorie karetních plateb. Odchází jen anonymizovaný název obchodníka – žádné účty ani částky.'],
    ];
@endphp
<x-ui.section title="AI joby">
    <p class="small text-body-secondary">Která úloha běží a na kterém modelu.</p>
    <x-ui.setting-row label="Hlavní / výchozí agent" help="Používá se všude, kde není nastavena konkrétní výjimka.">
        <div class="d-flex gap-2">
            <select class="form-select"><option>Anthropic Claude</option><option>OpenAI-kompatibilní</option></select>
            <select class="form-select"><option>claude-sonnet-5-5</option></select>
        </div>
    </x-ui.setting-row>
    @foreach ($jobs as [$label, $help])
        <x-ui.setting-row :label="$label" :help="$help">
            <div class="d-flex gap-2">
                <select class="form-select">@foreach ($providerOptions as $value => $option)<option>{{ $option }}</option>@endforeach</select>
                <select class="form-select"><option>— výchozí model providera —</option></select>
            </div>
            @if ($label === 'Auto-tagování feedu')
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="allow-new-tags">
                    <label class="form-check-label small" for="allow-new-tags">Umožnit vytvářet nové štítky</label>
                </div>
            @endif
        </x-ui.setting-row>
    @endforeach
    <div class="d-flex justify-content-end mt-3"><button class="btn btn-primary btn-sm">Uložit přiřazení úloh</button></div>
</x-ui.section>
