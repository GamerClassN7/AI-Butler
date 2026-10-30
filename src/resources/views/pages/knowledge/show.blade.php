<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="AI-Butler" :breadcrumb="['/znalosti' => 'Znalosti', '#' => 'AI-Butler']">
            <button class="btn btn-light"><i class="fas fa-code-merge me-1"></i> Sloučit</button>
            <x-ui.add-button label="Upravit" title="Upravit pojem" icon="fas fa-pen" variant="light" :fields="[['label' => 'Název'], ['label' => 'Shrnutí', 'type' => 'textarea']]" />
        </x-ui.page-header>

        <div class="row g-3">
            <div class="col-lg-8">
                <x-ui.section title="Shrnutí" class="mb-4">
                    <p class="mb-0">Osobní AI asistent. Laravel 13 + steelants/laravel-boilerplate, Bootstrap 5, Livewire 3. Nahrazuje OrbitHelper.</p>
                </x-ui.section>
                <x-ui.section title="Zdroje" icon="fas fa-paperclip">
                    <div class="list-group list-flat">
                        <x-ui.list-item title="Re: Nový stack" subtitle="E-mail · 30. 10." icon="fas fa-envelope" color="info" href="#" />
                        <x-ui.list-item title="Nasadit AI-Butler wireframe" subtitle="Úkol" icon="fas fa-list-check" color="warning" href="#" />
                    </div>
                </x-ui.section>
            </div>
            <div class="col-lg-4">
                <x-ui.section title="Vlastnosti" class="mb-4">
                    <x-boilerplate::detail-list :items="['Typ' => 'Projekt', 'Vytvořeno' => '30. 10. 2026', 'Zdroj' => 'Ručně']" />
                </x-ui.section>
                <x-ui.section title="Související" icon="fas fa-link">
                    <div class="d-flex flex-wrap gap-2">
                        <x-badge color="secondary" variant="subtle">Boilerplate</x-badge>
                        <x-badge color="secondary" variant="subtle">Nasazení</x-badge>
                        <x-badge color="secondary" variant="subtle">OrbitHelper</x-badge>
                    </div>
                </x-ui.section>
            </div>
        </div>
    </div>
</x-layout-app>
