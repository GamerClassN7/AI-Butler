{{-- Wireframe 1:1 with OrbitHelper Pages/Schedule (WeekGrid + MobileSchedule). Static demo data, no drag/drop yet. --}}
@php
    $hourPx = 56;
    $gutter = 42;
    $today = today();
    $weekStart = $today->copy()->startOfWeek();
    $days = collect(range(0, 6))->map(fn ($i) => $weekStart->copy()->addDays($i));
    $weekdayLabels = ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'];
    $workingHours = ['days' => [1, 2, 3, 4, 5], 'start' => 8, 'end' => 16.5];
    $holidays = [];

    $customers = [
        'acme' => ['label' => 'ACME', 'color' => '#f97316'],
        'beta' => ['label' => 'BETA', 'color' => '#10b981'],
        'int' => ['label' => 'Interní', 'color' => '#6366f1'],
        'cal' => ['label' => 'Google kalendář', 'color' => '#64748b'],
    ];
    // [day offset, start hour, end hour, customer, title, outline (calendar event, not reported)]
    $events = [
        [0, 8, 9.5, 'int', 'Plánování týdne', false], [0, 9.5, 12, 'acme', 'API integrace', false], [0, 13, 16, 'acme', 'API integrace', false],
        [1, 8, 12, 'beta', 'Migrace DB', false], [1, 10, 11, 'cal', 'Standup', true], [1, 12.5, 16.5, 'beta', 'Migrace DB', false],
        [2, 9, 11.5, 'acme', 'Review', false], [2, 13, 15, 'int', 'AI-Butler', false],
        [3, 8, 10, 'acme', 'Hotfix', false], [3, 10, 11, 'cal', 'Review s klientem', true], [3, 11, 14.5, 'beta', 'Reporting', false],
        [4, 8.5, 12, 'int', 'AI-Butler', false],
    ];

    $fmtHours = fn ($h) => rtrim(rtrim(number_format($h, 2, ',', ''), '0'), ',');
    $fmtTime = fn ($h) => sprintf('%02d:%02d', floor($h), round(($h - floor($h)) * 60));
    $reported = fn ($dayIndex) => collect($events)->where(0, $dayIndex)->where(5, false)->sum(fn ($e) => $e[2] - $e[1]);
    $weekTotal = collect(range(0, 6))->sum($reported);
    $isWeekend = fn ($day) => $day->isoWeekday() >= 6;

    $dayHeaderBg = fn ($day) => $day->isSameDay($today) ? 'var(--weekend)' : ($isWeekend($day) ? 'var(--line-soft)' : 'var(--surface)');
    $gridLines = "repeating-linear-gradient(to bottom, var(--line) 0 1px, transparent 1px " . ($hourPx / 2) . "px, var(--line-soft) " . ($hourPx / 2) . "px calc(" . ($hourPx / 2) . "px + 1px), transparent calc(" . ($hourPx / 2) . "px + 1px) {$hourPx}px)";
    $columnStyle = function ($day) use ($today, $workingHours, $hourPx, $gridLines) {
        $isToday = $day->isSameDay($today);
        $working = in_array($day->isoWeekday(), $workingHours['days']);
        $startPx = $working ? round($workingHours['start'] * $hourPx) : 0;
        $endPx = $working ? round($workingHours['end'] * $hourPx) : 0;
        $within = $isToday ? 'var(--weekend)' : 'var(--surface)';
        $outside = $isToday ? 'color-mix(in srgb, var(--weekend) 55%, var(--line-soft))' : 'var(--line-soft)';

        return "background-color: {$within}; background-image: {$gridLines}, linear-gradient(to bottom, {$outside} 0 {$startPx}px, transparent {$startPx}px {$endPx}px, {$outside} {$endPx}px 100%)";
    };
    $rangeTitle = $weekStart->month === $days->last()->month
        ? "{$weekStart->day}. – {$days->last()->day}. {$days->last()->month}. {$days->last()->year}"
        : "{$weekStart->day}. {$weekStart->month}. – {$days->last()->day}. {$days->last()->month}. {$days->last()->year}";
    $nowTop = round((now()->hour + now()->minute / 60) * $hourPx);
    $legend = collect($events)->pluck(3)->unique()->map(fn ($key) => $customers[$key]);

    $addFields = [
        ['label' => 'Zákazník', 'type' => 'select', 'options' => ['acme' => 'ACME', 'beta' => 'BETA', 'int' => 'Interní']],
        ['label' => 'Začátek', 'type' => 'datetime-local'], ['label' => 'Délka', 'type' => 'text'], ['label' => 'Poznámka', 'type' => 'textarea'],
    ];
@endphp

@php
    // One grid body (hour gutter + day columns + events + now line) – used by the week grid and the phone day view.
    $renderBody = function ($bodyDays, $fill = false) use ($hourPx, $gutter, $events, $weekStart, $columnStyle, $customers, $fmtTime, $today, $nowTop) {
        return view('pages.partials.schedule-grid-body', compact('bodyDays', 'fill', 'hourPx', 'gutter', 'events', 'weekStart', 'columnStyle', 'customers', 'fmtTime', 'today', 'nowTop'));
    };
@endphp

<x-layout-app>
    <div class="container-fluid px-lg-4">
        {{-- Desktop / tablet: WeekGrid --}}
        <div class="panel schedule-fill d-none d-lg-flex flex-column">
            <div class="d-flex flex-wrap align-items-center gap-2 border-bottom px-3 py-2">
                <h1 class="fs-5 fw-bold mb-0 me-2">Rozvrh</h1>
                <x-ui.period-nav :value="$today->toDateString()" />
                <button type="button" class="btn btn-sm border">Duplikovat včerejšek</button>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="d-flex align-items-baseline gap-1">
                        <span class="text-body-secondary" style="font-size: 11px">Vykázáno</span>
                        <span class="font-mono fw-bold small">{{ $fmtHours($weekTotal) }} h</span>
                        <span class="font-mono text-body-secondary" style="font-size: 11px">/ 40 h</span>
                    </div>
                    <div class="vr"></div>
                    <div class="fw-bold" style="font-size: 17px">{{ $rangeTitle }}</div>
                    <x-ui.add-button label="Přidat" title="Ruční výkaz" class="btn-sm" :fields="$addFields" />
                </div>
            </div>

            <div class="d-grid border-bottom" style="grid-template-columns: {{ $gutter }}px repeat(7, minmax(0, 1fr))">
                <div class="border-end"></div>
                @foreach ($days as $i => $day)
                    <div class="position-relative border-end py-1 text-center" style="background: {{ $dayHeaderBg($day) }}">
                        @if (isset($holidays[$day->toDateString()]))
                            <i class="fas fa-house position-absolute top-0 end-0 m-1 text-body-secondary" style="font-size: 10px" title="{{ $holidays[$day->toDateString()] }}"></i>
                        @endif
                        <div class="fw-semibold" style="font-size: 12.5px">{{ $weekdayLabels[$day->dayOfWeek] }} {{ $day->day }}. {{ $day->month }}.</div>
                        <div class="font-mono text-body-secondary fw-medium" style="font-size: 10.5px">{{ $reported($i) ? $fmtHours($reported($i)) . ' h' : '—' }}</div>
                    </div>
                @endforeach
            </div>

            {!! $renderBody($days, fill: true) !!}

            <div class="d-flex flex-wrap align-items-center gap-3 border-top py-2 px-3 text-body-secondary" style="font-size: 11.5px">
                @foreach ($legend as $item)
                    <div class="d-flex align-items-center gap-1">
                        <span class="d-block rounded-1" style="width: 10px; height: 10px; background: {{ $item['color'] }}"></span>{{ $item['label'] }}
                    </div>
                @endforeach
                <div class="ms-auto text-body-tertiary">Tažením v prázdné ploše přidáš ruční výkaz</div>
            </div>
        </div>

        {{-- Phone: MobileSchedule (day strip + single day) --}}
        <div class="panel d-flex d-lg-none flex-column mb-5">
            <div class="border-bottom px-3 pt-3">
                <div class="d-flex gap-1 overflow-hidden">
                    @foreach ($days as $i => $day)
                        @php($active = $day->isSameDay($today))
                        <button type="button" class="flex-fill min-w-0 rounded-3 border py-1 text-center"
                            style="background: {{ $active ? 'var(--accent)' : 'var(--surface)' }}; border-color: {{ $active ? 'var(--accent)' : 'var(--line)' }} !important">
                            <div class="text-uppercase" style="font-size: 10px; letter-spacing: .08em; color: {{ $active ? 'rgba(255,255,255,.8)' : 'var(--bs-secondary-color)' }}">{{ $weekdayLabels[$day->dayOfWeek] }}</div>
                            <div class="font-mono fw-bold small" style="color: {{ $active ? '#fff' : ($isWeekend($day) ? 'var(--bs-secondary-color)' : 'var(--bs-body-color)') }}">{{ $day->day }}</div>
                            <div class="mx-auto mt-1 rounded-pill" style="height: 3px; width: 14px; background: {{ $reported($i) ? ($active ? 'rgba(255,255,255,.85)' : 'var(--accent)') : 'transparent' }}"></div>
                        </button>
                    @endforeach
                </div>
                <div class="d-flex align-items-center gap-2 py-2">
                    <span class="fw-semibold" style="font-size: 13.5px">{{ $weekdayLabels[$today->dayOfWeek] }} {{ $today->day }}. {{ $today->month }}.</span>
                    <span class="font-mono text-body-secondary" style="font-size: 11.5px">{{ $fmtHours($reported($today->dayOfWeekIso - 1)) }} h vykázáno</span>
                    <x-ui.period-nav class="ms-auto" :value="$today->toDateString()" />
                </div>
            </div>

            {!! $renderBody(collect([$today])) !!}

            <x-ui.add-button label="" title="Ruční výkaz" icon="fas fa-plus" class="fab-button" variant="primary" :fields="$addFields" aria-label="Přidat ruční výkaz" />
        </div>
    </div>
</x-layout-app>
