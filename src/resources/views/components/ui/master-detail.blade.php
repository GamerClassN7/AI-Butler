{{--
    List + detail. From lg up both panes are side by side; below lg only one pane
    is visible and selecting an item switches to the detail (back button returns).
    Flex + gap instead of .row – negative row margins overflowed narrow containers.
--}}
@props(['listWidth' => '24rem'])

<div {{ $attributes->class(['d-flex flex-column flex-lg-row align-items-lg-start gap-3']) }} x-data="{ detail: false }" x-on:open-detail.window="detail = true">
    <div class="flex-shrink-0 min-w-0 w-lg-list" :class="detail && 'd-none d-lg-block'" style="--list-w: {{ $listWidth }}">
        {{ $list }}
    </div>
    <div class="flex-grow-1 min-w-0" :class="!detail && 'd-none d-lg-block'">
        <button type="button" class="btn btn-sm btn-light mb-2 d-lg-none" x-on:click="detail = false">
            <i class="fas fa-arrow-left me-1"></i> {{ __('Zpět') }}
        </button>
        {{ $detail }}
    </div>
</div>
