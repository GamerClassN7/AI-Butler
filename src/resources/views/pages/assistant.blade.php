<x-layout-app>
    <x-slot:subNavigation>
        <div class="p-2">
            <button class="btn btn-primary w-100 mb-3"><i class="fas fa-plus me-1"></i> Nová konverzace</button>
            <div class="small text-body-tertiary px-2 mb-1">Dnes</div>
            <ul class="app-nav nav flex-column">
                <li class="nav-item is-active"><a class="nav-link" href="#"><div class="nav-link-title text-truncate">Shrnutí pošty za týden</div></a></li>
                <li class="nav-item"><a class="nav-link" href="#"><div class="nav-link-title text-truncate">Návrh odpovědi Acme</div></a></li>
            </ul>
            <div class="small text-body-tertiary px-2 mt-3 mb-1">Starší</div>
            <ul class="app-nav nav flex-column">
                <li class="nav-item"><a class="nav-link" href="#"><div class="nav-link-title text-truncate">Plán sprintu</div></a></li>
            </ul>
        </div>
    </x-slot:subNavigation>

    <div class="container-xl d-flex flex-column" style="min-height: calc(100vh - 8rem)">
        <x-ui.page-header title="Asistent" subtitle="Shrnutí pošty za týden">
            <x-boilerplate::dropdown>
                <x-boilerplate::dropdown-item icon="fas fa-pen">Přejmenovat</x-boilerplate::dropdown-item>
                <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Smazat</x-boilerplate::dropdown-item>
            </x-boilerplate::dropdown>
        </x-ui.page-header>

        <div class="flex-grow-1 d-flex flex-column gap-3 mb-3">
            <div class="align-self-end bg-primary-subtle rounded-3 p-3" style="max-width: 40rem">Shrň mi poštu za tento týden, co je důležité?</div>
            <div class="d-flex gap-3" style="max-width: 48rem">
                <x-boilerplate::icon-tile icon="fas fa-wand-magic-sparkles" size="sm" />
                <div class="flex-grow-1">
                    <p class="mb-2">Tento týden přišlo 46 e-mailů. Důležité:</p>
                    <ul class="mb-2">
                        <li>Acme poslala nabídku – čeká na odpověď do pátku.</li>
                        <li>Faktura 2026-118 je po splatnosti.</li>
                    </ul>
                    <div class="d-flex flex-wrap gap-2">
                        <x-badge color="secondary" variant="subtle" icon="fas fa-envelope">Re: Nabídka</x-badge>
                        <x-badge color="secondary" variant="subtle" icon="fas fa-envelope">Faktura 2026-118</x-badge>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel sticky-bottom mb-5 mb-lg-0">
            <div class="p-2 d-flex gap-2 align-items-end">
                <textarea class="form-control border-0 shadow-none" rows="2" placeholder="Napiš zprávu…"></textarea>
                <button class="btn btn-light btn-sq" title="Příloha"><i class="fas fa-paperclip"></i></button>
                <button class="btn btn-primary btn-sq" title="Odeslat"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</x-layout-app>
