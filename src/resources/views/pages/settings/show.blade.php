@use(App\Support\SettingsSections)

<x-layout-app>
    <x-slot:subNavigation>@include('pages.settings._subnav', ['current' => $section])</x-slot:subNavigation>

    <div class="container-xl">
        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-light mb-2 d-lg-none"><i class="fas fa-chevron-left me-1"></i> Nastavení</a>
        @include('pages.settings._page', ['section' => $section])
    </div>
</x-layout-app>
