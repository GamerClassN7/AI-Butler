{{--
    List + detail. From lg up both panes are side by side; below lg only one pane
    is visible and selecting an item switches to the detail (back button returns).
--}}
@props(['listWidth' => '24rem'])

<div {{ $attributes->class(['row g-3']) }} x-data="{ detail: false }" x-on:open-detail.window="detail = true">
    <div class="col-lg-auto" :class="detail && 'd-none d-lg-block'" style="--list-w: {{ $listWidth }}">
        <div class="w-lg-list">{{ $list }}</div>
    </div>
    <div class="col-lg" :class="!detail && 'd-none d-lg-block'">
        <button type="button" class="btn btn-sm btn-light mb-2 d-lg-none" x-on:click="detail = false">
            <i class="fas fa-arrow-left me-1"></i> {{ __('Zpět') }}
        </button>
        {{ $detail }}
    </div>
</div>
