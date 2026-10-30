{{-- Settings: one page, section nav on the left (horizontal strip below lg) with scroll-spy – structure 1:1 with OrbitHelper Settings/Edit. --}}
@php
    $sections = [
        'connectors' => 'Konektory',
        'webhooks' => 'Webhooky',
        'worklog' => 'Worklog',
        'finance' => 'Finance',
        'geolocation' => 'Geolokace',
        'ai-models' => 'AI modely',
        'ai-jobs' => 'AI joby',
        'knowledge' => 'Znalosti',
        'notifications' => 'Notifikace',
        'app' => 'Aplikace',
        'logging' => 'Logování',
    ];
    // Sections needing attention (e.g. a connector with an expired token).
    $badges = ['connectors' => 1];
@endphp

<x-layout-app>
    <div class="container-xl" x-data="{
        active: @js(array_key_first($sections)),
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.filter((e) => e.isIntersecting).forEach((e) => this.active = e.target.id.replace('settings-', ''));
            }, { rootMargin: '0px 0px -70% 0px' });
            this.$el.querySelectorAll('[data-settings-section]').forEach((el) => observer.observe(el));
        },
        go(key) { document.getElementById('settings-' + key).scrollIntoView({ behavior: 'smooth', block: 'start' }); },
    }">
        <x-ui.page-header title="Nastavení" subtitle="Účty, integrace a chování aplikace." />

        <div class="row g-4">
            <div class="col-lg-auto">
                <nav class="nav nav-pills flex-nowrap flex-lg-column overflow-auto gap-1 sticky-top bg-body py-2 py-lg-0" style="top: 1rem; width: auto; min-width: 12rem">
                    @foreach ($sections as $key => $label)
                        <button type="button" class="nav-link text-start text-nowrap d-flex align-items-center justify-content-between gap-2"
                            :class="active === @js($key) && 'active'" x-on:click="go(@js($key))">
                            <span>{{ $label }}</span>
                            @isset($badges[$key])
                                <span class="badge rounded-pill text-bg-warning">{{ $badges[$key] }}</span>
                            @endisset
                        </button>
                    @endforeach
                </nav>
            </div>

            <div class="col-lg min-w-0 pb-5">
                @foreach ($sections as $key => $label)
                    <div id="settings-{{ $key }}" data-settings-section style="scroll-margin-top: 1rem" class="mb-5">
                        @include('pages.settings.' . $key)
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout-app>
