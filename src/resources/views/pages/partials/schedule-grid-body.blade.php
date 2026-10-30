{{-- ScheduleGridBody: hour gutter, day columns (working-hours shading), events, now line. Starts scrolled to 7:00. --}}
<div class="sched-scroll overflow-y-auto overflow-x-hidden {{ $fill ? 'flex-grow-1' : '' }}" style="{{ $fill ? 'min-height: 0' : 'max-height: calc(100vh - 15rem)' }}" x-data x-init="$el.scrollTop = {{ 7 * $hourPx }}">
    <div class="position-relative d-grid" style="grid-template-columns: {{ $gutter }}px repeat({{ $bodyDays->count() }}, minmax(0, 1fr)); height: {{ 24 * $hourPx }}px">
        <div class="position-relative border-end">
            @foreach (range(1, 23) as $hour)
                <div class="position-absolute end-0 me-1 font-mono text-body-secondary" style="top: {{ $hour * $hourPx - 7 }}px; font-size: 10.5px">{{ sprintf('%02d:00', $hour) }}</div>
            @endforeach
        </div>

        @foreach ($bodyDays as $day)
            @php($offset = $weekStart->diffInDays($day))
            <div class="position-relative border-end" style="{{ $columnStyle($day) }}">
                @foreach (collect($events)->where(0, $offset) as [$d, $start, $end, $customer, $title, $outline])
                    <div @class(['sched-event', 'is-outline' => $outline])
                        style="top: {{ round($start * $hourPx) }}px; height: {{ max(18, round(($end - $start) * $hourPx) - 2) }}px; left: 2px; right: 2px; z-index: {{ $outline ? 3 : 2 }}; {{ $outline ? 'color' : 'background' }}: {{ $customers[$customer]['color'] }}">
                        <div class="sched-event-time">{{ $fmtTime($start) }}–{{ $fmtTime($end) }}</div>
                        <div class="sched-event-title">{{ $title }}</div>
                    </div>
                @endforeach

                @if ($day->isSameDay($today))
                    <div class="position-absolute start-0 end-0 bg-danger pe-none" style="top: {{ $nowTop }}px; height: 2px; z-index: 6">
                        <span class="position-absolute rounded-circle bg-danger" style="top: -3px; left: -4px; width: 8px; height: 8px"></span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
