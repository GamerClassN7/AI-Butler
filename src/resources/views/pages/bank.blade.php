@php
    $transactions = [
        ['Albert Hypermarket', 'Potraviny', '−1 284 Kč', 'danger', '30. 10.'],
        ['Výplata', 'Příjem', '+58 000 Kč', 'success', '29. 10.'],
        ['Netflix', 'Předplatné', '−329 Kč', 'danger', '28. 10.'],
        ['ČEZ', 'Energie', '−2 100 Kč', 'danger', '27. 10.'],
    ];
@endphp
<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Banka" subtitle="Účet ****2043">
            <button class="btn btn-light"><i class="fas fa-file-import me-1"></i> Import výpisu</button>
        </x-ui.page-header>

        <div class="row g-3 mb-3">
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Zůstatek" value="84 320 Kč" icon="fas fa-wallet" color="primary" /></div>
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Příjmy (říjen)" value="58 000 Kč" icon="fas fa-arrow-down" color="success" /></div>
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Výdaje (říjen)" value="31 450 Kč" icon="fas fa-arrow-up" color="danger" /></div>
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Měsíční platby" value="7" icon="fas fa-repeat" color="info" /></div>
        </div>

        <x-boilerplate::tab.group default="transactions" query="tab">
            <x-boilerplate::tab.tabs>
                <x-boilerplate::tab.tab name="transactions">Transakce</x-boilerplate::tab.tab>
                <x-boilerplate::tab.tab name="recurring">Měsíční platby</x-boilerplate::tab.tab>
                <x-boilerplate::tab.tab name="spending">Útrata</x-boilerplate::tab.tab>
                <x-boilerplate::tab.tab name="flow">Tok peněz</x-boilerplate::tab.tab>
            </x-boilerplate::tab.tabs>
            <x-boilerplate::tab.panel name="transactions">
                <x-ui.toolbar class="mt-3" placeholder="Hledat transakci…">
                    <select class="form-select w-auto"><option>Všechny kategorie</option></select>
                </x-ui.toolbar>
                <x-ui.section>
                    <div class="list-group list-flat">
                        @foreach ($transactions as [$name, $category, $amount, $color, $date])
                            <x-ui.list-item :title="$name" :subtitle="$category" :meta="$date" icon="fas fa-receipt">
                                <x-slot:trailing><span class="font-monospace fw-semibold text-{{ $color }} text-nowrap">{{ $amount }}</span></x-slot:trailing>
                            </x-ui.list-item>
                        @endforeach
                    </div>
                </x-ui.section>
            </x-boilerplate::tab.panel>
            <x-boilerplate::tab.panel name="recurring">
                <x-boilerplate::empty-state class="mt-3" icon="fas fa-repeat" title="Měsíční platby" description="Pravidelné platby rozpoznané z výpisů." />
            </x-boilerplate::tab.panel>
            <x-boilerplate::tab.panel name="spending">
                <x-ui.placeholder class="mt-3" label="Graf útraty podle kategorií" icon="fas fa-chart-pie" height="18rem" />
            </x-boilerplate::tab.panel>
            <x-boilerplate::tab.panel name="flow">
                <x-ui.placeholder class="mt-3" label="Tok peněz v čase" icon="fas fa-chart-line" height="18rem" />
            </x-boilerplate::tab.panel>
        </x-boilerplate::tab.group>
    </div>
</x-layout-app>
