{{-- Wireframe 1:1 with OrbitHelper Pages/Reports (Index + FinanceForecastCard). Static demo data. --}}
@php
    $today = today();
    $monthStart = $today->copy()->startOfMonth();
    $days = collect(range(0, $monthStart->daysInMonth - 1))->map(fn ($i) => $monthStart->copy()->addDays($i));
    $dayAbbrev = [1 => 'po', 2 => 'út', 3 => 'st', 4 => 'čt', 5 => 'pá', 6 => 'so', 7 => 'ne'];

    // Hours per working day, deterministic demo pattern (only days up to today).
    $pattern = [
        'ACME' => ['color' => '#fdba74', 'md' => 12.5, 'mdLimit' => 15, 'rate' => 9600, 'hours' => [3, 4, 0, 5, 2.5]],
        'BETA' => ['color' => '#6ee7b7', 'md' => 6, 'mdLimit' => 5, 'rate' => 8800, 'hours' => [2, 0, 4, 1.5, 3]],
        'INT' => ['color' => '#c4b5fd', 'md' => 2.25, 'mdLimit' => null, 'rate' => 0, 'hours' => [1, 2, 1.5, 0, 1]],
    ];
    $rows = collect($pattern)->map(function ($row, $code) use ($days, $today) {
        $byDate = $days->mapWithKeys(fn ($day) => [
            $day->toDateString() => ($day->isoWeekday() <= 5 && $day->lte($today)) ? $row['hours'][($day->day) % 5] : 0,
        ]);
        $total = $byDate->sum();

        return $row + ['code' => $code, 'byDate' => $byDate, 'total' => $total, 'md' => $total / 8, 'price' => $total / 8 * $row['rate'], 'overLimit' => $row['mdLimit'] !== null && $total / 8 > $row['mdLimit']];
    })->values();
    $dailyTotals = $days->mapWithKeys(fn ($day) => [$day->toDateString() => $rows->sum(fn ($r) => $r['byDate'][$day->toDateString()])]);
    $grandHours = $dailyTotals->sum();
    $grandMd = $rows->sum('md');
    $grandPrice = $rows->sum('price');
    $paidRows = $rows->where('price', '>', 0);
    $daysWithEntries = $days->filter(fn ($day) => $dailyTotals[$day->toDateString()] > 0);

    $fmt = fn ($h) => $h > 0 ? rtrim(rtrim(number_format(round($h * 4) / 4, 2, ',', ''), '0'), ',') : '';
    $fmtNumber = fn ($n) => rtrim(rtrim(number_format($n, 2, ',', ''), '0'), ',') ?: '0';
    $fmtCurrency = fn ($n) => number_format($n, 0, ',', ' ') . ' Kč';
    $isWeekend = fn ($day) => $day->isoWeekday() >= 6;
    $dayHeadClass = fn ($day) => $day->isSameDay($today) ? 'bg-weekend' : ($isWeekend($day) ? 'bg-line-soft' : '');
    $dayTotalHeadClass = fn ($day) => $day->isSameDay($today) ? 'bg-weekend' : ($isWeekend($day) ? 'bg-line-soft' : 'bg-surface-sunken');

    $targetAmount = 250000;
    $cashFlow = ['estimatedBalance' => 84320, 'upcomingRecurring' => 12450, 'upcomingCount' => 4, 'projectedBalance' => 71870];
    $cashFlowHealthy = $cashFlow['projectedBalance'] > 0;

    $addFields = [
        ['label' => 'Zákazník', 'type' => 'select', 'options' => ['acme' => 'ACME', 'beta' => 'BETA', 'int' => 'INT']],
        ['label' => 'Začátek', 'type' => 'datetime-local'], ['label' => 'Hodin', 'type' => 'number'], ['label' => 'Poznámka', 'type' => 'textarea'],
    ];
@endphp

<x-layout-app>
    <div class="container-fluid px-lg-4 d-flex flex-column gap-2">
        {{-- Toolbar – same controls as Rozvrh --}}
        <div class="panel d-flex flex-wrap align-items-center gap-2 px-3 py-2 mb-2">
            <h1 class="fs-5 fw-bold mb-0 me-2">Výkazy práce</h1>
            <x-ui.period-nav picker="month" :value="$today->format('Y-m')" :label="$monthStart->locale('cs')->isoFormat('MMMM YYYY')" />

            <div class="ms-auto d-none d-lg-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm border fw-semibold">Kopírovat jako obrázek</button>
                <x-ui.add-button label="Přidat záznam" title="Přidat záznam" class="btn-sm fw-semibold" :fields="$addFields" />
            </div>
        </div>

        {{-- FinanceForecastCard --}}
        <div class="d-flex flex-column flex-lg-row align-items-lg-stretch gap-2 mb-2">
            <div class="panel d-flex flex-column justify-content-center flex-shrink-0 px-3 py-2" style="min-width: 9rem">
                <div class="text-body-secondary" style="font-size: 11px">Aktuální tržby</div>
                <div class="font-mono fs-5 fw-bold">{{ $fmtCurrency($grandPrice) }}</div>
                <div class="font-mono text-body-secondary fw-medium" style="font-size: 10.5px">Limit {{ $fmtCurrency($targetAmount) }}</div>
                <div class="d-flex align-items-center gap-1 mt-1">
                    <span class="rounded-circle bg-success flex-shrink-0" style="width: 8px; height: 8px"></span>
                    <span class="fw-semibold text-success" style="font-size: 10.5px">Na dobré cestě</span>
                </div>
            </div>

            <div class="panel d-flex flex-column justify-content-center gap-1 flex-grow-1 min-w-0 px-3 py-2">
                @foreach ($paidRows as $row)
                    <div class="d-flex align-items-center gap-2">
                        <span class="flex-shrink-0 rounded-1" style="width: 9px; height: 9px; background: {{ $row['color'] }}"></span>
                        <span class="flex-shrink-0 text-truncate fw-semibold small" style="width: 3.5rem">{{ $row['code'] }}</span>
                        <span class="position-relative flex-grow-1 min-w-0 overflow-hidden rounded-pill bg-surface-sunken" style="height: 7px">
                            <span class="position-absolute top-0 bottom-0 start-0 rounded-pill" style="width: {{ $grandPrice ? round($row['price'] / $grandPrice * 100, 1) : 0 }}%; background: {{ $row['color'] }}"></span>
                        </span>
                        <span class="flex-shrink-0 text-end font-mono fw-bold small" style="width: 5rem">{{ $fmtCurrency($row['price']) }}</span>
                    </div>
                @endforeach
            </div>

            <div @class(['panel d-flex flex-column justify-content-center flex-shrink-0 px-3 py-2', 'border-danger-subtle bg-danger-subtle' => !$cashFlowHealthy]) style="min-width: 16rem">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <span class="fw-semibold text-body-secondary" style="font-size: 11px">Cash-flow do konce měsíce</span>
                    <span @class(['fw-semibold', 'text-success' => $cashFlowHealthy, 'text-danger' => !$cashFlowHealthy]) style="font-size: 10.5px">{{ $cashFlowHealthy ? 'V pořádku' : 'Nedostatek' }}</span>
                </div>
                <div class="d-grid mt-1" style="grid-template-columns: 1fr auto; column-gap: .75rem; font-size: 11px">
                    <span class="text-body-secondary">Odhad na účtech</span>
                    <span class="text-end font-mono fw-semibold">{{ $fmtCurrency($cashFlow['estimatedBalance']) }}</span>
                    <span class="text-body-secondary">Ještě pravidelně ({{ $cashFlow['upcomingCount'] }})</span>
                    <span class="text-end font-mono fw-semibold text-danger">−{{ $fmtCurrency($cashFlow['upcomingRecurring']) }}</span>
                    <span class="fw-semibold">Po platbách</span>
                    <span @class(['text-end font-mono fw-bold', 'text-success' => $cashFlowHealthy, 'text-danger' => !$cashFlowHealthy])>{{ $fmtCurrency($cashFlow['projectedBalance']) }}</span>
                </div>
                <a href="{{ route('bank.index') }}" class="mt-1 fw-medium text-decoration-none" style="font-size: 10px">Jen rozpoznané pravidelné platby · detail →</a>
            </div>
        </div>

        {{-- Hours summary --}}
        <div class="d-flex flex-column flex-lg-row align-items-lg-stretch gap-2 mb-2">
            <div class="panel d-flex flex-column justify-content-center flex-shrink-0 px-3 py-2" style="min-width: 9rem">
                <div class="text-body-secondary" style="font-size: 11px">Celkem v měsíci</div>
                <div class="d-flex align-items-baseline gap-1">
                    <span class="font-mono fs-5 fw-bold">{{ $fmt($grandHours) ?: '0' }}</span>
                    <span class="font-mono small text-body-secondary">h</span>
                </div>
                <div class="font-mono text-body-secondary fw-medium" style="font-size: 10.5px">{{ $fmtNumber($grandMd) }} MD</div>
            </div>

            <div class="panel d-flex flex-column justify-content-center gap-1 flex-grow-1 min-w-0 px-3 py-2">
                @foreach ($rows as $row)
                    <div class="d-flex align-items-center gap-2">
                        <span class="flex-shrink-0 rounded-1" style="width: 9px; height: 9px; background: {{ $row['color'] }}"></span>
                        <span class="flex-shrink-0 text-truncate fw-semibold small" style="width: 3.5rem">{{ $row['code'] }}</span>
                        <span class="position-relative flex-grow-1 min-w-0 overflow-hidden rounded-pill bg-surface-sunken" style="height: 7px">
                            <span class="position-absolute top-0 bottom-0 start-0 rounded-pill" style="width: {{ $grandHours ? round($row['total'] / $grandHours * 100, 1) : 0 }}%; background: {{ $row['color'] }}"></span>
                        </span>
                        <span class="flex-shrink-0 text-end font-mono fw-bold small" style="width: 2.75rem">{{ $fmt($row['total']) }}</span>
                        <span class="d-none d-sm-inline flex-shrink-0 text-end font-mono text-body-secondary" style="width: 74px; font-size: 10.5px">{{ $fmtNumber($row['md']) }} MD</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Desktop / tablet: day × customer matrix --}}
        <div class="d-none d-lg-block">
            <div class="panel overflow-hidden overflow-x-auto">
                <table class="w-100 text-center mb-0" style="table-layout: fixed; font-size: 11px; border-collapse: collapse">
                    <colgroup>
                        <col style="width: 8rem">
                        @foreach ($days as $day)<col>@endforeach
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="border-end border-bottom px-2 py-1 text-start fw-medium text-body-secondary">Datum</th>
                            @foreach ($days as $day)
                                <th class="border-end border-bottom px-0 py-1 fw-medium text-nowrap overflow-hidden text-body-secondary {{ $dayHeadClass($day) }}">{{ $day->day }}.{{ $day->month }}.</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="border-end border-bottom px-2 py-1 text-start fw-medium text-body-tertiary">Den</th>
                            @foreach ($days as $day)
                                <th class="border-end border-bottom px-0 py-1 fw-normal text-truncate text-body-tertiary {{ $dayHeadClass($day) }}">{{ $dayAbbrev[$day->isoWeekday()] }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="border-end border-bottom bg-surface-sunken px-2 py-1 text-start fw-medium text-body-secondary">Hodiny</th>
                            @foreach ($days as $day)
                                <th class="border-end border-bottom px-0 py-1 fw-semibold text-nowrap overflow-hidden {{ $dayTotalHeadClass($day) }}">{{ $fmt($dailyTotals[$day->toDateString()]) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr class="border-bottom">
                                <td class="text-truncate border-end px-2 py-1 text-start fw-bold" style="border-left: 4px solid {{ $row['color'] }} !important">
                                    {{ $row['code'] }}
                                    @if ($row['mdLimit'] !== null)
                                        <span @class(['d-block text-nowrap font-mono fw-medium', 'text-danger' => $row['overLimit'], 'text-body-tertiary' => !$row['overLimit']]) style="font-size: 10px">
                                            {{ $fmtNumber($row['md']) }}/{{ $fmtNumber($row['mdLimit']) }} MD
                                        </span>
                                    @endif
                                </td>
                                @foreach ($days as $day)
                                    @php($hours = $row['byDate'][$day->toDateString()])
                                    <td class="overflow-hidden border-end px-0 py-1 font-mono fw-bold text-nowrap {{ $hours > 0 ? '' : $dayHeadClass($day) }}"
                                        @if ($hours > 0) style="background: {{ $row['color'] }}; cursor: pointer; color: #1e293b" @endif>{{ $fmt($hours) }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr><td colspan="{{ $days->count() + 1 }}" class="px-3 py-4 text-body-secondary">Žádné výkazy pro tento měsíc.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex align-items-center gap-3 px-1 pt-2 text-body-secondary" style="font-size: 11.5px">
                <span>Prázdná buňka = nic nevykázáno</span>
                <span class="d-flex align-items-center gap-1"><span class="d-block rounded-1 border bg-line-soft" style="width: 11px; height: 11px"></span>víkend</span>
                <span class="d-flex align-items-center gap-1"><span class="d-block rounded-1 border bg-weekend" style="width: 11px; height: 11px"></span>dnes</span>
            </div>
        </div>

        {{-- Phone: list of days with data --}}
        <div class="d-lg-none">
            <div class="mb-2 px-1 fw-semibold text-uppercase text-body-secondary" style="font-size: 11.5px; letter-spacing: .06em">Vykázané dny</div>
            <div class="d-flex flex-column gap-2 pb-5 mb-5">
                @forelse ($daysWithEntries->reverse() as $day)
                    <div class="panel d-flex align-items-center gap-3 px-3 py-2 rounded-3" style="min-height: 2.75rem">
                        <div class="flex-shrink-0 text-center" style="width: 2.75rem">
                            <div class="font-mono fw-bold lh-sm">{{ $day->day }}</div>
                            <div class="text-body-secondary" style="font-size: 11px">{{ $dayAbbrev[$day->isoWeekday()] }}</div>
                        </div>
                        <div class="vr"></div>
                        <div class="d-flex flex-wrap gap-1 flex-grow-1 min-w-0">
                            @foreach ($rows as $row)
                                @if ($row['byDate'][$day->toDateString()] > 0)
                                    <button type="button" class="btn btn-sm rounded-pill d-inline-flex align-items-center gap-1 fw-semibold py-0 px-2" style="background: {{ $row['color'] }}; color: #1e293b; font-size: 12px">
                                        {{ $row['code'] }}<span class="font-mono fw-bold opacity-75">{{ $fmt($row['byDate'][$day->toDateString()]) }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex-shrink-0 font-mono fw-bold small">{{ $fmt($dailyTotals[$day->toDateString()]) }}</div>
                    </div>
                @empty
                    <p class="px-1 small text-body-secondary">Žádné výkazy pro tento měsíc.</p>
                @endforelse
                @if ($daysWithEntries->isNotEmpty())
                    <p class="pt-1 text-center text-body-secondary" style="font-size: 11.5px">Ostatní dny v měsíci jsou bez záznamu</p>
                @endif
            </div>

            <x-ui.add-button label="" title="Přidat záznam" class="fab-button" :fields="$addFields" aria-label="Přidat záznam" />
        </div>
    </div>
</x-layout-app>
