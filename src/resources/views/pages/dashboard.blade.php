<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Dobré ráno" subtitle="Čtvrtek 30. října">
            <a class="btn btn-primary" href="{{ route('assistant.index') }}"><i class="fas fa-wand-magic-sparkles me-1"></i> Zeptat se asistenta</a>
        </x-ui.page-header>

        <div class="row g-3 mb-3">
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Dnes schůzek" value="4" icon="fas fa-calendar-week" color="primary" :href="route('schedule.index')" /></div>
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Nepřečtená pošta" value="12" icon="fas fa-envelope" color="info" :href="route('mail.index')" /></div>
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Úkoly po termínu" value="3" icon="fas fa-list-check" color="danger" :href="route('tasks.index')" /></div>
            <div class="col-6 col-lg-3"><x-boilerplate::stat label="Vykázáno tento týden" value="18,5 h" icon="fas fa-clock" color="success" :href="route('reports.index')" /></div>
        </div>

        <div class="row g-3">
            <div class="col-lg-7">
                <x-ui.section title="Dnešní program" icon="fas fa-calendar-day">
                    <x-slot:actions><a class="btn btn-sm btn-light" href="{{ route('schedule.index') }}">Rozvrh</a></x-slot:actions>
                    <div class="list-group list-flat">
                        <x-ui.list-item title="Standup" subtitle="Google Meet" meta="09:00" icon="fas fa-video" color="primary" />
                        <x-ui.list-item title="Review s klientem" subtitle="Zasedačka 2" meta="11:30" icon="fas fa-users" color="warning" />
                        <x-ui.list-item title="Oběd" meta="12:30" icon="fas fa-utensils" />
                        <x-ui.list-item title="Deep work – AI-Butler" meta="14:00" icon="fas fa-laptop-code" color="success" />
                    </div>
                </x-ui.section>
            </div>
            <div class="col-lg-5">
                <x-ui.section title="Návrhy asistenta" icon="fas fa-wand-magic-sparkles" class="mb-4">
                    <div class="list-group list-flat">
                        <x-ui.list-item title="Odpovědět na nabídku od Acme" subtitle="E-mail čeká 2 dny" icon="fas fa-reply" color="info">
                            <x-slot:trailing><button class="btn btn-sm btn-light">Koncept</button></x-slot:trailing>
                        </x-ui.list-item>
                        <x-ui.list-item title="Vykázat středu" subtitle="Chybí 3 h" icon="fas fa-clock" color="warning">
                            <x-slot:trailing><button class="btn btn-sm btn-light">Doplnit</button></x-slot:trailing>
                        </x-ui.list-item>
                    </div>
                </x-ui.section>
                <x-ui.section title="Poslední pošta" icon="fas fa-envelope">
                    <div class="list-group list-flat">
                        <x-ui.list-item title="Faktura 2026-118" subtitle="účtárna@firma.cz" meta="08:12" avatar="Účtárna" unread :href="route('mail.index')" />
                        <x-ui.list-item title="Re: Termín nasazení" subtitle="Petr Novák" meta="včera" avatar="Petr Novák" :href="route('mail.index')" />
                    </div>
                </x-ui.section>
            </div>
        </div>
    </div>
</x-layout-app>
