@php
    $mails = [
        ['Účtárna', 'Faktura 2026-118', 'Dobrý den, v příloze zasíláme fakturu…', '08:12', true],
        ['Petr Novák', 'Re: Termín nasazení', 'Souhlasím, pátek je ok.', 'včera', false],
        ['Acme s.r.o.', 'Nabídka spolupráce', 'Na základě schůzky posíláme…', 'út', true],
        ['GitHub', '[AI-Butler] New push', 'GamerClassN7 pushed 3 commits…', 'po', false],
    ];
@endphp
<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Pošta">
            <x-ui.add-button label="Napsat" title="Nový e-mail" icon="fas fa-pen" :fields="[
                ['label' => 'Účet', 'type' => 'select', 'options' => ['work' => 'prace@firma.cz', 'gmail' => 'osobni@gmail.com']],
                ['label' => 'Komu', 'type' => 'email'], ['label' => 'Předmět'], ['label' => 'Zpráva', 'type' => 'textarea'],
            ]" />
        </x-ui.page-header>

        <x-ui.master-detail>
            <x-slot:list>
                <x-ui.toolbar>
                    <select class="form-select w-auto"><option>Všechny účty</option><option>prace@firma.cz</option><option>osobni@gmail.com</option></select>
                </x-ui.toolbar>
                <x-boilerplate::nav-switch class="mb-2" :options="['all' => 'Vše', 'unread' => 'Nepřečtené', 'starred' => 'S hvězdičkou']" value="all" />
                <div class="list-group list-flat">
                    @foreach ($mails as $i => [$from, $subject, $preview, $time, $unread])
                        <x-ui.list-item :title="$subject" :subtitle="$from . ' · ' . $preview" :meta="$time" :avatar="$from" :unread="$unread" :active="$i === 0"
                            href="#" x-on:click.prevent="$dispatch('open-detail')" />
                    @endforeach
                </div>
            </x-slot:list>
            <x-slot:detail>
                <x-ui.section>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <x-avatar name="Účtárna" />
                        <div class="me-auto">
                            <div class="fw-semibold">Faktura 2026-118</div>
                            <div class="small text-body-secondary">Účtárna &lt;ucetni@firma.cz&gt; · dnes 08:12</div>
                        </div>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-light" title="Odpovědět"><i class="fas fa-reply"></i></button>
                            <x-boilerplate::dropdown>
                                <x-boilerplate::dropdown-item icon="fas fa-envelope-open">Označit nepřečtené</x-boilerplate::dropdown-item>
                                <x-boilerplate::dropdown-item icon="fas fa-box-archive">Archivovat</x-boilerplate::dropdown-item>
                                <x-boilerplate::dropdown-item icon="fas fa-trash" danger>Smazat</x-boilerplate::dropdown-item>
                            </x-boilerplate::dropdown>
                        </div>
                    </div>
                    <div class="alert alert-info d-flex gap-2 small"><i class="fas fa-wand-magic-sparkles mt-1"></i> Asistent: faktura je 5 dní po splatnosti, částka 12 400 Kč.</div>
                    <x-ui.placeholder label="Tělo e-mailu" icon="fas fa-align-left" height="16rem" class="mb-4" />
                    <x-badge color="secondary" variant="subtle" icon="fas fa-paperclip">faktura-2026-118.pdf</x-badge>
                </x-ui.section>
            </x-slot:detail>
        </x-ui.master-detail>
    </div>
</x-layout-app>
