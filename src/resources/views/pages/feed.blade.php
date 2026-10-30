{{-- Wireframe 1:1 with OrbitHelper Pages/Feed – Read Later hub (articles, links, notes). Static demo data. --}}
@php
    $kindLabels = ['article' => 'Článek', 'video' => 'Video', 'note' => 'Poznámka', 'file' => 'Soubor'];
    $counts = ['unread' => 7, 'all' => 12, 'starred' => 2, 'read' => 5];
    $tags = ['laravel' => 4, 'ai' => 3, 'design' => 2, 'osobni' => 1];
    $items = [
        ['article', 'Livewire 4: co je nového', 'laravel-news.com', 6, 'Přehled změn v novém Livewire – single-file komponenty, rychlejší hydratace…', ['laravel'], true, false, true],
        ['video', 'Building agents with tool use', 'youtube.com', 18, 'Přednáška o návrhu agentů s nástroji a o tom, kdy je nepoužívat.', ['ai'], false, false, true],
        ['note', 'Nápad: týdenní souhrn pošty', null, 1, 'Každý pátek poslat shrnutí nevyřízených e-mailů a navrhnout odpovědi.', ['ai', 'osobni'], false, false, null],
        ['article', 'Designing calm interfaces', 'smashingmagazine.com', 9, 'Proč méně rámečků a stínů působí moderněji a jak pracovat s bílým prostorem.', ['design'], true, true, true],
        ['file', 'faktura-2026-118.pdf', null, 2, null, [], false, true, null],
    ];
@endphp

<x-layout-app>
    <div class="container-xl">
        <x-ui.page-header title="Feed" subtitle="Read Later hub, články, odkazy a poznámky.">
            <div class="input-group input-group-sm" style="width: 16rem">
                <span class="input-group-text"><i class="fas fa-magnifying-glass"></i></span>
                <input type="search" class="form-control" placeholder="Hledat ve feedu…">
            </div>
            <x-ui.add-button label="Přidat" title="Nový záznam do feedu" class="btn-sm d-none d-lg-inline-block" :fields="[
                ['label' => 'Vložte odkaz, přetáhněte soubor, vložte screenshot ze schránky nebo napište poznámku.', 'type' => 'note'],
                ['label' => 'Obsah', 'type' => 'textarea'], ['label' => 'Štítky'], ['label' => 'Vlastní název'], ['label' => 'Přímý odkaz URL', 'type' => 'url'],
            ]" />
        </x-ui.page-header>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-2 mb-3">
            <ul class="nav nav-pills small">
                @foreach (['unread' => 'K přečtení', 'all' => 'Vše', 'starred' => 'Oblíbené', 'read' => 'Přečtené'] as $key => $label)
                    <li class="nav-item">
                        <a @class(['nav-link py-1 px-2 d-flex align-items-center gap-1', 'active' => $key === 'unread']) href="#">
                            {{ $label }} <span class="badge rounded-pill {{ $key === 'unread' ? 'text-bg-light' : 'text-bg-secondary bg-opacity-25 text-body' }}">{{ $counts[$key] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <select class="form-select form-select-sm w-auto">
                <option>Nejnovější</option>
                <option>Nejstarší</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-1 overflow-auto pb-1 mb-3 small">
            <span class="section-title me-1 flex-shrink-0">Štítky:</span>
            @foreach ($tags as $tag => $count)
                <a href="#" class="btn btn-sm border rounded-pill py-0 px-2 flex-shrink-0">#{{ $tag }} <span class="opacity-50">({{ $count }})</span></a>
            @endforeach
        </div>

        <div class="row g-3 mb-5">
            @foreach ($items as [$kind, $title, $domain, $minutes, $snippet, $itemTags, $starred, $read, $cover])
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <article @class(['panel h-100 d-flex flex-column justify-content-between overflow-hidden rounded-4', 'opacity-75' => $read])>
                        <div>
                            @if ($cover)
                                <a href="#" class="position-relative d-block bg-body-tertiary" style="aspect-ratio: 16 / 9">
                                    <span class="d-flex w-100 h-100 align-items-center justify-content-center text-body-tertiary"><i class="far fa-image fs-2"></i></span>
                                    <span class="position-absolute top-0 start-0 m-2 badge rounded-pill text-bg-dark bg-opacity-75">{{ $domain }}</span>
                                </a>
                            @endif
                            <div class="p-3">
                                <div class="d-flex align-items-center gap-2 mb-2 small text-body-secondary">
                                    <span class="fw-bold text-uppercase" style="font-size: 10px; letter-spacing: .05em">{{ $kindLabels[$kind] }}</span>
                                    @if (!$cover && $domain)<span class="badge rounded-pill bg-body-tertiary text-body-secondary">{{ $domain }}</span>@endif
                                    <span class="me-auto" style="font-size: 11px">{{ $minutes }} min čtení</span>
                                    <button type="button" class="btn btn-sm btn-link text-body-secondary p-0" title="Líbí se"><i class="far fa-thumbs-up"></i></button>
                                    <button type="button" class="btn btn-sm btn-link text-body-secondary p-0" title="Nelíbí se"><i class="far fa-thumbs-down"></i></button>
                                    <button type="button" @class(['btn btn-sm btn-link p-0', 'text-warning' => $starred, 'text-body-secondary' => !$starred]) title="Oblíbené"><i class="{{ $starred ? 'fas' : 'far' }} fa-star"></i></button>
                                </div>
                                <h2 class="fs-6 fw-semibold mb-1"><a href="#" class="text-reset text-decoration-none">{{ $title }}</a></h2>
                                @if ($snippet)
                                    <p @class(['small text-body-secondary mb-2', 'border-start border-2 ps-2' => $kind === 'note'])>{{ $snippet }}</p>
                                @endif
                                @if ($itemTags)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($itemTags as $tag)
                                            <a href="#" class="badge bg-body-tertiary text-body-secondary text-decoration-none fw-medium">#{{ $tag }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-top bg-body-tertiary px-3 py-2">
                            <button type="button" @class(['btn btn-sm py-0 px-2 text-nowrap', 'btn-success' => $read, 'border bg-body' => !$read])>
                                <i class="fas fa-check me-1"></i>{{ $read ? 'Přečteno' : 'Hotovo' }}
                            </button>
                            <div class="d-flex align-items-center gap-1">
                                @if ($domain)<a href="#" class="btn btn-sm btn-link text-body-secondary p-1" title="Přejít na původní web"><i class="fas fa-arrow-up-right-from-square"></i></a>@endif
                                <a href="#" class="btn btn-sm btn-link text-body-secondary text-decoration-none text-nowrap py-0">Detail →</a>
                                <button type="button" class="btn btn-sm btn-link text-body-secondary p-1" title="Smazat"><i class="far fa-trash-can"></i></button>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <x-ui.add-button label="" title="Nový záznam do feedu" class="fab-button" aria-label="Přidat do feedu" :fields="[
            ['label' => 'Obsah', 'type' => 'textarea'], ['label' => 'Štítky'],
        ]" />
    </div>
</x-layout-app>
