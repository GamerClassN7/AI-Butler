@use(App\Support\SettingsSections)
@php($item = SettingsSections::all()[$section])
<div style="max-width: 60rem" class="pb-5">
    <x-ui.page-header :title="$item['label']" :subtitle="$item['description']" />
    @include('pages.settings.' . $section)
</div>
