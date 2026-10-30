{{-- Wireframe 1:1 with OrbitHelper Pages/Tasks (QuickAddRow, FilterChips, TaskList, TaskDetail, AddTaskModal). Static demo data. --}}
@php
    $filter = request('filter', 'open');
    $filters = ['open' => 'Otevřené', 'jira' => 'Jira', 'email' => 'E-mail', 'manual' => 'Ruční', 'done' => 'Hotové'];
    $customers = ['acme' => ['ACME', '#fdba74'], 'beta' => ['BETA', '#6ee7b7'], 'int' => ['INT', '#c4b5fd']];

    // Jira rows are read-only: no checkbox, no timer, no delete.
    $row = fn (array $r) => $r + ['jira' => null, 'jiraStatus' => null, 'jiraCategory' => null, 'priority' => null, 'due' => null, 'overdue' => false, 'estimate' => null,
        'customer' => null, 'origin' => null, 'done' => false, 'timer' => null, 'description' => null, 'email' => null];
    $groups = [
        'Po termínu' => [
            $row(['id' => 1, 'title' => 'Dopsat nabídku pro Acme', 'priority' => 'Vysoká', 'due' => 'út 28. 10. 17:00', 'overdue' => true, 'estimate' => '2 h', 'customer' => 'acme', 'origin' => 'E-mail',
                'description' => 'Rozsah podle schůzky, cena za MD dle smlouvy.', 'email' => ['Nabídka spolupráce', 'Petr Novák <petr@acme.cz>', 'út 28. 10. 9:12']]),
        ],
        'Dnes' => [
            $row(['id' => 2, 'title' => 'Nasadit AI-Butler wireframe', 'priority' => 'Střední', 'due' => 'dnes 16:00', 'estimate' => '1 h', 'customer' => 'int', 'origin' => 'Ruční', 'timer' => '0:42:13']),
            $row(['id' => 3, 'title' => 'Opravit export faktur', 'jira' => 'ACME-412', 'jiraStatus' => 'In Progress', 'jiraCategory' => 'indeterminate', 'due' => 'dnes', 'customer' => 'acme', 'origin' => 'Jira']),
        ],
        'Tento týden' => [
            $row(['id' => 4, 'title' => 'Zaplatit fakturu 2026-118', 'due' => 'pá 31. 10.', 'origin' => 'E-mail', 'email' => ['Faktura 2026-118', 'Účtárna <ucetni@firma.cz>', 'čt 30. 10. 8:12']]),
            $row(['id' => 5, 'title' => 'Review migrace DB', 'jira' => 'BETA-88', 'jiraStatus' => 'To Do', 'jiraCategory' => 'new', 'due' => 'pá 31. 10.', 'customer' => 'beta', 'origin' => 'Jira']),
        ],
        'Bez termínu' => [
            $row(['id' => 6, 'title' => 'Objednat servis auta', 'priority' => 'Nízká', 'origin' => 'Ruční']),
        ],
        'Hotové dnes' => [
            $row(['id' => 7, 'title' => 'Odpovědět Petrovi na termín nasazení', 'origin' => 'E-mail', 'done' => true]),
        ],
    ];
    $all = collect($groups)->flatten(1)->keyBy('id');
    $selected = $all[1];

    $priorityClass = fn ($p) => $p === 'Vysoká' ? 'bg-danger-subtle text-danger-emphasis' : 'bg-warning-subtle text-warning-emphasis';
    $statusClass = fn ($c) => match ($c) { 'done' => 'bg-success-subtle text-success-emphasis', 'indeterminate' => 'bg-info-subtle text-info-emphasis', default => 'bg-body-tertiary text-body-secondary' };
    $addFields = [
        ['label' => 'Úkol – např. „Odeslat nabídku zítra 14:00“ (termín se rozpozná z textu)'], ['label' => 'Poznámka', 'type' => 'textarea'],
        ['label' => 'Priorita', 'type' => 'select', 'options' => ['' => '— žádná —', 'low' => 'Nízká', 'mid' => 'Střední', 'high' => 'Vysoká']],
        ['label' => 'Odhad (h)', 'type' => 'text'], ['label' => 'Zákazník', 'type' => 'select', 'options' => ['' => '— žádný —'] + collect($customers)->map(fn ($c) => $c[0])->all()],
    ];
@endphp

<x-layout-app>
    <div class="container-fluid px-lg-4 d-flex flex-column gap-3 pb-5">
        {{-- QuickAddRow – desktop only; on a phone it is the FAB --}}
        <div class="panel d-none d-lg-block px-3 py-2" x-data="{ expanded: false, text: '' }">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <input type="text" class="form-control form-control-sm flex-grow-1 w-auto" x-model="text" placeholder="Nový úkol — např. „Odeslat nabídku zítra 14:00“">
                @foreach (['dnes', 'zítra', 'pá'] as $chip)
                    <button type="button" class="btn btn-sm border rounded-pill py-0 px-2 text-body-secondary" x-on:click="text = (text.trim() + ' {{ $chip }}').trim()">{{ $chip }}</button>
                @endforeach
                <button type="button" class="btn btn-sm border fw-semibold" x-on:click="expanded = !expanded" :aria-expanded="expanded">
                    Podrobnosti <span x-text="expanded ? '▴' : '▾'"></span>
                </button>
                <button type="button" class="btn btn-sm btn-primary fw-semibold" :disabled="text.trim() === ''">Přidat</button>
            </div>
            <div class="row g-2 border-top mt-2 pt-2" x-show="expanded" x-cloak>
                <div class="col-12"><label class="form-label small fw-semibold mb-1">Poznámka</label><textarea class="form-control form-control-sm" rows="2"></textarea></div>
                <div class="col-sm-6">
                    <label class="form-label small fw-semibold mb-1">Priorita</label>
                    <select class="form-select form-select-sm"><option>— žádná —</option><option>Nízká</option><option>Střední</option><option>Vysoká</option></select>
                </div>
                <div class="col-sm-6"><label class="form-label small fw-semibold mb-1">Odhad (h)</label><input type="text" inputmode="decimal" placeholder="0,5" class="form-control form-control-sm"></div>
                <div class="col-12">
                    <label class="form-label small fw-semibold mb-1">Zákazník</label>
                    <select class="form-select form-select-sm"><option>— žádný —</option>@foreach ($customers as [$name])<option>{{ $name }}</option>@endforeach</select>
                </div>
            </div>
        </div>

        {{-- FilterChips --}}
        <div class="d-flex flex-wrap gap-1">
            @foreach ($filters as $key => $label)
                <a href="?filter={{ $key }}" @class(['btn btn-sm rounded-pill border py-0 px-2', 'bg-body-secondary text-body fw-medium' => $filter === $key, 'text-body-secondary' => $filter !== $key])>{{ $label }}</a>
            @endforeach
        </div>

        <x-ui.master-detail list-width="28rem">
            <x-slot:list>
                {{-- TaskList --}}
                <div class="d-flex flex-column gap-3" x-data="{ sel: {{ $selected['id'] }} }">
                    @foreach ($groups as $label => $rows)
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-2 px-1">
                                <span class="fw-bold text-uppercase text-body-secondary" style="font-size: 10.5px; letter-spacing: .07em">{{ $label }}</span>
                                <span class="badge rounded-pill bg-body-secondary text-body-secondary font-mono">{{ count($rows) }}</span>
                                <span class="flex-grow-1 border-top"></span>
                            </div>
                            <div class="panel overflow-hidden">
                                @foreach ($rows as $r)
                                    <div class="task-row d-flex align-items-start gap-3 px-3 py-2 border-bottom"
                                        :class="sel === {{ $r['id'] }} && 'is-selected'" @class(['bg-body-tertiary text-body-secondary' => $r['done']])>
                                        @if (!$r['jira'])
                                            <button type="button" title="{{ $r['done'] ? 'Obnovit úkol' : 'Dokončit úkol' }}"
                                                @class(['task-check mt-1 flex-shrink-0 d-flex align-items-center justify-content-center rounded border', 'bg-success border-success text-white' => $r['done']])>
                                                @if ($r['done'])<i class="fas fa-check" style="font-size: 10px"></i>@endif
                                            </button>
                                        @else
                                            <span class="task-check mt-1 flex-shrink-0"></span>
                                        @endif

                                        <button type="button" class="btn p-0 border-0 text-start flex-grow-1 min-w-0" x-on:click="sel = {{ $r['id'] }}; $dispatch('open-detail')">
                                            <span class="d-flex flex-wrap align-items-baseline gap-2">
                                                @if ($r['jira'])<span class="font-mono text-body-secondary" style="font-size: 11px">{{ $r['jira'] }}</span>@endif
                                                <span @class(['small fw-medium', 'text-decoration-line-through' => $r['done']])>{{ $r['title'] }}</span>
                                                @if ($r['priority'])<span class="rounded px-1 fw-bold {{ $priorityClass($r['priority']) }}" style="font-size: 10px">{{ $r['priority'] }}</span>@endif
                                                @if ($r['jiraStatus'])<span class="rounded px-1 fw-medium {{ $statusClass($r['jiraCategory']) }}" style="font-size: 10px">{{ $r['jiraStatus'] }}</span>@endif
                                            </span>
                                            <span class="d-flex flex-wrap align-items-center column-gap-3 row-gap-1 mt-1 text-body-secondary" style="font-size: 12px">
                                                @if ($r['due'])<span @class(['fw-semibold text-danger' => $r['overdue']])>Termín {{ $r['due'] }}</span>@endif
                                                @if ($r['estimate'])<span>Odhad {{ $r['estimate'] }}</span>@endif
                                                @if ($r['customer'])
                                                    <span class="d-inline-flex align-items-center gap-1"><span class="rounded-1" style="width: 8px; height: 8px; background: {{ $customers[$r['customer']][1] }}"></span>{{ $customers[$r['customer']][0] }}</span>
                                                @endif
                                                @if ($r['origin'])<span>{{ $r['origin'] }}</span>@endif
                                            </span>
                                        </button>

                                        @if (!$r['jira'] && !$r['done'])
                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                @if ($r['timer'])
                                                    <span class="live-dot rounded-circle bg-danger" style="width: 6px; height: 6px"></span>
                                                    <span class="font-mono small text-body-secondary">{{ $r['timer'] }}</span>
                                                    <button type="button" class="btn btn-sm border text-danger py-0 px-1" style="font-size: 11px">Stop</button>
                                                @else
                                                    <button type="button" class="btn btn-sm border text-body-secondary py-0 px-1" style="font-size: 11px">▶ Start</button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-slot:list>

            <x-slot:detail>
                {{-- TaskDetail --}}
                @php($r = $selected)
                <div class="panel p-4 d-flex flex-column gap-3" x-data="{ editing: false }">
                    <div class="d-flex align-items-start justify-content-between gap-3 border-bottom pb-3">
                        <h2 class="fs-5 fw-semibold mb-0 text-break" x-show="!editing">{{ $r['title'] }}</h2>
                        <input type="text" class="form-control fw-semibold" value="{{ $r['title'] }}" x-show="editing" x-cloak>
                        <button type="button" class="btn btn-sm border flex-shrink-0" x-on:click="editing = !editing" x-text="editing ? 'Hotovo' : 'Upravit'">Upravit</button>
                        @if ($r['priority'])<span class="rounded px-2 py-1 fw-bold flex-shrink-0 {{ $priorityClass($r['priority']) }}" style="font-size: 11px" x-show="!editing">{{ $r['priority'] }}</span>@endif
                    </div>

                    <div class="d-flex flex-column gap-2 small">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-body-secondary flex-shrink-0" style="width: 6rem">Termín</span>
                            <span class="font-mono {{ $r['overdue'] ? 'fw-semibold text-danger' : '' }}" x-show="!editing">{{ $r['due'] }}</span>
                            <input type="datetime-local" class="form-control form-control-sm font-mono w-auto" value="2026-10-28T17:00" x-show="editing" x-cloak>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-body-secondary flex-shrink-0" style="width: 6rem">Odhad</span>
                            <span class="font-mono" x-show="!editing">{{ $r['estimate'] }}</span>
                            <input type="text" inputmode="decimal" class="form-control form-control-sm font-mono" style="width: 6rem" placeholder="0,5" value="2" x-show="editing" x-cloak>
                        </div>
                        <div x-show="editing" x-cloak>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-body-secondary flex-shrink-0" style="width: 6rem">Priorita</span>
                                <select class="form-select form-select-sm w-auto"><option>— žádná —</option><option>Nízká</option><option>Střední</option><option selected>Vysoká</option></select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-body-secondary flex-shrink-0" style="width: 6rem">Zákazník</span>
                            <span x-show="!editing">
                                <span class="d-inline-flex align-items-center gap-1 fw-medium">
                                    <span class="rounded-1" style="width: 10px; height: 10px; background: {{ $customers[$r['customer']][1] }}"></span>{{ $customers[$r['customer']][0] }}
                                </span>
                            </span>
                            <select class="form-select form-select-sm w-auto" x-show="editing" x-cloak><option>— žádný —</option>@foreach ($customers as [$name])<option @selected($name === 'ACME')>{{ $name }}</option>@endforeach</select>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-body-secondary flex-shrink-0" style="width: 6rem">Zdroj</span>
                            <a href="{{ route('mail.index') }}" class="text-decoration-underline" style="text-decoration-style: dotted !important">{{ $r['origin'] }}</a>
                        </div>
                    </div>

                    <p class="small text-body-secondary border-top pt-3 mb-0" x-show="!editing">{{ $r['description'] }}</p>
                    <textarea class="form-control form-control-sm" rows="3" placeholder="Poznámka" x-show="editing" x-cloak>{{ $r['description'] }}</textarea>

                    @if ($r['email'])
                        <div class="rounded-3 border bg-body-tertiary px-3 py-2 d-flex flex-column gap-1">
                            <span class="fw-bold text-uppercase text-body-secondary" style="font-size: 10.5px; letter-spacing: .07em">Navázaná pošta</span>
                            <span class="small fw-medium">{{ $r['email'][0] }}</span>
                            <span class="text-body-secondary" style="font-size: 12px">{{ $r['email'][1] }}</span>
                            <span class="text-body-secondary" style="font-size: 12px">{{ $r['email'][2] }}</span>
                        </div>
                    @endif

                    {{-- KnowledgePanel --}}
                    <section class="rounded-3 border bg-body-tertiary px-3 py-2 d-flex flex-column gap-2">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <span class="fw-bold text-uppercase text-body-secondary" style="font-size: 10.5px; letter-spacing: .07em">Znalosti</span>
                            <button type="button" class="btn btn-sm btn-link text-body-secondary text-decoration-none py-0"><i class="fas fa-link me-1"></i>Propojit…</button>
                        </div>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="d-inline-flex align-items-center border rounded-2 bg-body small">
                                <a href="{{ route('knowledge.show') }}" class="px-2 py-1 fw-medium text-reset text-decoration-none">Acme s.r.o.</a>
                                <button type="button" class="btn btn-sm text-body-secondary px-1 py-0" aria-label="Odpojit Acme s.r.o."><i class="fas fa-xmark" style="font-size: 10px"></i></button>
                            </span>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <span class="text-body-secondary" style="font-size: 11px">Související</span>
                            <div class="d-flex align-items-start gap-2">
                                <a href="{{ route('knowledge.show') }}" class="flex-grow-1 min-w-0 text-reset text-decoration-none">
                                    <span class="d-block small fw-medium text-truncate">Ceník a sazby 2026</span>
                                    <span class="d-block text-body-secondary text-truncate" style="font-size: 12px">MD sazba pro <mark class="p-0 bg-primary-subtle">nabídky</mark> je 9 600 Kč…</span>
                                </a>
                                <button type="button" class="btn btn-sm text-body-secondary" title="Připnout" aria-label="Připnout"><i class="fas fa-thumbtack"></i></button>
                            </div>
                        </div>
                    </section>

                    {{-- Timer --}}
                    <div class="rounded-3 border bg-body-tertiary px-3 py-2 d-flex align-items-center justify-content-between gap-3">
                        <span class="small text-body-secondary">Časovač neběží.</span>
                        <button type="button" class="btn btn-sm border bg-body">▶ Spustit časovač</button>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2 border-top pt-3">
                        <button type="button" class="btn btn-sm btn-success-subtle border border-success-subtle text-success-emphasis bg-success-subtle">Dokončit úkol</button>
                        <a href="{{ route('schedule.index') }}" class="btn btn-sm border">→ Rozvrh</a>
                        <button type="button" class="btn btn-sm border border-danger-subtle text-danger">Smazat</button>
                    </div>
                </div>
            </x-slot:detail>
        </x-ui.master-detail>

        <x-ui.add-button label="" title="Nový úkol" class="fab-button" aria-label="Nový úkol" :fields="$addFields" />
    </div>
</x-layout-app>
