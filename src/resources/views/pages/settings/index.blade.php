{{-- /nastaveni: hub on mobile (like OrbitHelper "Víc"), first section on desktop. --}}
@use(App\Support\SettingsSections)
@php($first = array_key_first(SettingsSections::all()))

<x-layout-app>
    <x-slot:subNavigation>@include('pages.settings._subnav', ['current' => $first])</x-slot:subNavigation>

    <div class="container-xl">
        <div class="d-lg-none mx-auto" style="max-width: 42rem">
            <x-ui.page-header title="Nastavení" subtitle="Účty, integrace a chování aplikace." />
            <div class="list-group list-flat mb-5">
                @foreach (SettingsSections::all() as $key => $item)
                    <a href="{{ route('settings.show', $key) }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                        <x-boilerplate::icon-tile :icon="$item['icon']" size="sm" color="secondary" />
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-medium">{{ $item['label'] }}</div>
                            <div class="small text-body-secondary text-truncate">{{ $item['description'] }}</div>
                        </div>
                        @isset(SettingsSections::badges()[$key])
                            <span class="badge rounded-pill text-bg-warning">{{ SettingsSections::badges()[$key] }}</span>
                        @endisset
                        <i class="fas fa-chevron-right small text-body-tertiary"></i>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="d-none d-lg-block">
            @include('pages.settings._page', ['section' => $first])
        </div>
    </div>
</x-layout-app>
