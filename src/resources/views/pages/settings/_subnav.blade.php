{{-- Desktop sub-navigation of settings (hidden below lg by the boilerplate layout – the hub replaces it there). --}}
@use(App\Support\SettingsSections)
<div class="p-2">
    <div class="small text-body-tertiary px-2 pt-2 mb-1">Nastavení</div>
    <ul class="app-nav nav flex-column">
        @foreach (SettingsSections::all() as $key => $item)
            <li @class(['nav-item', 'is-active' => $key === $current])>
                <a class="nav-link" href="{{ route('settings.show', $key) }}">
                    <i class="nav-link-ico {{ $item['icon'] }}"></i>
                    <div class="nav-link-title flex-grow-1">{{ $item['label'] }}</div>
                    @isset(SettingsSections::badges()[$key])
                        <span class="badge rounded-pill text-bg-warning">{{ SettingsSections::badges()[$key] }}</span>
                    @endisset
                </a>
            </li>
        @endforeach
    </ul>
</div>
