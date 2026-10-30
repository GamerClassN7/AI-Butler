{{-- Catalogue of app UI components. New screens must be built from these – add here when a new one appears. --}}
<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Komponenty" subtitle="Stavebnice obrazovek – x-ui.* + x-boilerplate::*">
            <x-ui.add-button label="Přidat" title="Ukázkový formulář" :fields="[['label' => 'Název'], ['label' => 'Popis', 'type' => 'textarea']]" />
        </x-ui.page-header>

        <div class="row g-3">
            <div class="col-lg-6">
                <x-ui.section title="x-ui.page-header" icon="fas fa-heading">
                    <p class="small text-body-secondary">Titulek stránky, podtitulek, breadcrumb, akce ve slotu. Na každé stránce.</p>
                    <code class="small">&lt;x-ui.page-header title="…" subtitle="…" :breadcrumb="[…]"&gt;akce&lt;/x-ui.page-header&gt;</code>
                </x-ui.section>
            </div>
            <div class="col-lg-6">
                <x-ui.section title="x-ui.add-button" icon="fas fa-plus">
                    <p class="small text-body-secondary">Přidávání vždy přes modal (boilerplate modal + <code>wireframe.form</code>).</p>
                    <x-ui.add-button label="Úkol" title="Nový úkol" :fields="[['label' => 'Název'], ['label' => 'Termín', 'type' => 'date']]" />
                </x-ui.section>
            </div>
            <div class="col-lg-6">
                <x-ui.section title="x-ui.list-item" icon="fas fa-list">
                    <div class="list-group list-flat">
                        <x-ui.list-item title="S ikonou" subtitle="podtitulek" meta="09:00" icon="fas fa-star" color="warning" />
                        <x-ui.list-item title="S avatarem, nepřečteno" subtitle="podtitulek" meta="včera" avatar="Petr Novák" unread />
                        <x-ui.list-item title="S akcí vpravo" icon="fas fa-bolt" color="info">
                            <x-slot:trailing><button class="btn btn-sm btn-light">Akce</button></x-slot:trailing>
                        </x-ui.list-item>
                    </div>
                </x-ui.section>
            </div>
            <div class="col-lg-6">
                <x-ui.section title="x-ui.toolbar + nav-switch" icon="fas fa-filter">
                    <x-ui.toolbar><select class="form-select w-auto"><option>Filtr</option></select></x-ui.toolbar>
                    <x-boilerplate::nav-switch :options="['a' => 'Vše', 'b' => 'Nepřečtené']" value="a" />
                </x-ui.section>
            </div>
            <div class="col-lg-6">
                <x-ui.section title="x-boilerplate::stat / progress" icon="fas fa-gauge">
                    <x-boilerplate::stat label="Hodnota" value="42" icon="fas fa-chart-simple" color="primary" class="mb-4" />
                    <x-boilerplate::progress :value="65" label="Průběh" />
                </x-ui.section>
            </div>
            <div class="col-lg-6">
                <x-ui.section title="x-boilerplate::empty-state" icon="fas fa-inbox">
                    <x-boilerplate::empty-state title="Nic tu není" description="Prázdný stav seznamu." />
                </x-ui.section>
            </div>
            <div class="col-12">
                <x-ui.section title="x-ui.master-detail" icon="fas fa-table-columns">
                    <p class="small text-body-secondary">Seznam + detail. Od lg vedle sebe, pod lg jeden panel (event <code>open-detail</code> přepne na detail).</p>
                    <x-ui.master-detail list-width="16rem">
                        <x-slot:list>
                            <div class="list-group list-flat">
                                <x-ui.list-item title="Položka 1" href="#" active x-on:click.prevent="$dispatch('open-detail')" />
                                <x-ui.list-item title="Položka 2" href="#" x-on:click.prevent="$dispatch('open-detail')" />
                            </div>
                        </x-slot:list>
                        <x-slot:detail>
                            <x-ui.placeholder label="Detail položky" height="8rem" />
                        </x-slot:detail>
                    </x-ui.master-detail>
                </x-ui.section>
            </div>
        </div>
    </div>
</x-layout-app>
