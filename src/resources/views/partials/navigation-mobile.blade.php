{{-- Bottom bar below lg. Items come from the "mobile-menu" registered in GenerateMenus – never hardcode links here. --}}
<div class="layout-nav-mobile">
    <ul class="app-nav nav">
        @foreach ($mobileMenuItems as $item)
            <li class="nav-item nav-item-mobile {{ ($item->isActive() || $item->isUse()) ? 'is-active' : '' }}">
                <a class="nav-link" href="{{ route($item->route) }}">
                    <i class="nav-link-ico {{ $item->icon }}"></i>
                    <span class="nav-link-content">{{ __($item->title) }}</span>
                </a>
            </li>
        @endforeach
        <li class="nav-item nav-item-mobile">
            <button type="button" class="nav-link w-100 border-0 bg-transparent" onclick="document.getElementById('layout-nav').classList.toggle('layout-nav-open')">
                <i class="nav-link-ico fas fa-bars"></i>
                <span class="nav-link-content">{{ __('Víc') }}</span>
            </button>
        </li>
    </ul>
</div>
