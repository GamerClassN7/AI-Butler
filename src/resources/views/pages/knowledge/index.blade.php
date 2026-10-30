@php
    $concepts = [
        ['AI-Butler', 'Projekt', 'Osobní asistent, Laravel + boilerplate.', 12],
        ['Acme s.r.o.', 'Zákazník', 'Klient od 2024, kontakt Petr Novák.', 8],
        ['Nasazení', 'Proces', 'Docker stack, Gitea CI, ruční schválení.', 5],
        ['Fakturace', 'Proces', 'Měsíčně k 5., podklady z výkazů.', 3],
        ['Petr Novák', 'Osoba', 'PM u Acme.', 4],
        ['Boilerplate', 'Technologie', 'steelants/laravel-boilerplate v3.', 6],
    ];
@endphp
<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Znalosti" subtitle="Co si asistent pamatuje">
            <x-boilerplate::nav-switch :options="['grid' => ['icon' => 'fas fa-grip'], 'graph' => ['icon' => 'fas fa-diagram-project']]" value="grid" />
            <x-ui.add-button label="Pojem" title="Nový pojem" :types="collect(['project' => ['Projekt', 'fas fa-diagram-project'], 'person' => ['Osoba', 'fas fa-user'], 'customer' => ['Zákazník', 'fas fa-handshake'], 'process' => ['Proces', 'fas fa-gears'], 'technology' => ['Technologie', 'fas fa-microchip']])
                ->map(fn ($t) => ['label' => $t[0], 'icon' => $t[1], 'fields' => [['label' => 'Název'], ['label' => 'Shrnutí', 'type' => 'textarea']]])->all()" />
        </x-ui.page-header>

        <x-ui.toolbar placeholder="Hledat ve znalostech…">
            <select class="form-select w-auto"><option>Všechny typy</option></select>
        </x-ui.toolbar>

        <x-ui.section title="Návrhy k zapamatování" icon="fas fa-lightbulb" class="mb-4">
            <div class="list-group list-flat">
                <x-ui.list-item title="Beta a.s. – nový zákazník" subtitle="Z e-mailu „Nabídka spolupráce“" icon="fas fa-envelope" color="info">
                    <x-slot:trailing>
                        <div class="d-flex gap-1"><button class="btn btn-sm btn-light">Zamítnout</button><button class="btn btn-sm btn-primary">Uložit</button></div>
                    </x-slot:trailing>
                </x-ui.list-item>
            </div>
        </x-ui.section>

        <x-ui.section title="Pojmy">
            <div class="list-group list-flat">
                @foreach ($concepts as [$name, $type, $summary, $links])
                    <x-ui.list-item :title="$name" :subtitle="$summary" icon="fas fa-brain" color="primary" :href="route('knowledge.show')">
                        <x-slot:trailing>
                            <div class="d-flex align-items-center gap-2 text-nowrap">
                                <x-badge color="secondary" variant="subtle" size="sm">{{ $type }}</x-badge>
                                <small class="text-body-tertiary"><i class="fas fa-link me-1"></i>{{ $links }}</small>
                            </div>
                        </x-slot:trailing>
                    </x-ui.list-item>
                @endforeach
            </div>
        </x-ui.section>
    </div>
</x-layout-app>
