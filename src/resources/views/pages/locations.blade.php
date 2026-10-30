<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Geolokace">
            <input type="date" class="form-control w-auto" value="2026-10-30">
            <x-ui.add-button label="Místo" title="Nové místo" :fields="[['label' => 'Název'], ['label' => 'Adresa'], ['label' => 'Poloměr (m)', 'type' => 'number']]" />
        </x-ui.page-header>

        <div class="row g-3">
            <div class="col-lg-8">
                <x-ui.placeholder label="Mapa – trasa dne a uložená místa" icon="fas fa-map-location-dot" height="28rem" />
            </div>
            <div class="col-lg-4">
                <x-ui.section title="Místa" icon="fas fa-location-dot" class="mb-4">
                    <div class="list-group list-flat">
                        <x-ui.list-item title="Kancelář" subtitle="Praha 7 · 6 h 20 min" icon="fas fa-building" color="primary" href="#" />
                        <x-ui.list-item title="Domov" subtitle="Praha 4 · 14 h" icon="fas fa-house" color="success" href="#" />
                        <x-ui.list-item title="Acme s.r.o." subtitle="Brno · 0 min" icon="fas fa-handshake" color="warning" href="#" />
                    </div>
                </x-ui.section>
                <x-ui.section title="Dnešní pohyb" icon="fas fa-route">
                    <x-boilerplate::detail-list :items="['Ujeto' => '18,4 km', 'Na cestě' => '52 min', 'Zastávek' => '3']" />
                </x-ui.section>
            </div>
        </div>
    </div>
</x-layout-app>
