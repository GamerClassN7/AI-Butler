<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SteelAnts\LaravelBoilerplate\Facades\Menu;
use Symfony\Component\HttpFoundation\Response;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guest()) {
            return $next($request);
        }

        if ($request->route()->getName() === 'livewire.message') {
            return $next($request);
        }

        $menuRoutes = [
            'Přehled'    => ['fas fa-house', 'home'],
            'Asistent'   => ['fas fa-wand-magic-sparkles', 'assistant.index'],
            'Rozvrh'     => ['fas fa-calendar-week', 'schedule.index'],
            'Výkazy'     => ['fas fa-clock', 'reports.index'],
            'Pošta'      => ['fas fa-envelope', 'mail.index'],
            'Úkoly'      => ['fas fa-list-check', 'tasks.index'],
            'Znalosti'   => ['fas fa-brain', 'knowledge.index'],
            'Feed'       => ['fas fa-rss', 'feed.index'],
            'Banka'      => ['fas fa-building-columns', 'bank.index'],
            'Geolokace'  => ['fas fa-location-dot', 'locations.index'],
            'Nastavení'  => ['fas fa-gear', 'settings.index'],
        ];

        // Bottom bar below lg – subset of main menu, rest is reachable via "Víc".
        $mobileRoutes = [
            'Přehled'  => $menuRoutes['Přehled'],
            'Rozvrh'   => $menuRoutes['Rozvrh'],
            'Úkoly'    => $menuRoutes['Úkoly'],
            'Pošta'    => $menuRoutes['Pošta'],
        ];

        $systemRoutes = [
            'Komponenty' => [
                'fas fa-shapes',
                'components.index',
            ],
            'Settings' => [
                'fas fa-cog',
                'system.setting.index',
            ],
            'Audit' => [
                'fas fa-eye',
                'system.audit.index',
            ],
            'User' => [
                'fas fa-users',
                'system.user.index',
            ],
            'Subscriptions' => [
                'fas fa-dollar-sign',
                'system.subscription.index',
            ],
            'File' => [
                'fas fa-folder',
                'system.file.index',
            ],
            'Logs' => [
                'fas fa-bug',
                'system.log.index',
            ],
            'Jobs' => [
                'fas fa-business-time',
                'system.jobs.index',
            ],
            'Cache' => [
                'fas fa-box',
                'system.cache.index',
            ],
            'Backup' => [
                'fas fa-file-archive',
                'system.backup.index',
            ],
        ];

        if (file_exists(base_path() . '/routes/api.php')) {
            $systemRoutes['Api'] = [
                'fas fa-rocket',
                'system.api.index',
            ];
        }

        $menus = [
            'main-menu'   => $menuRoutes,
            'mobile-menu' => $mobileRoutes,
            'system-menu' => $systemRoutes,
        ];

        foreach ($menus as $menuKey => $MenuItems) {
            $menu = Menu::get($menuKey) ?? Menu::make($menuKey, function () {});
            foreach ($MenuItems as $title => $route_data) {
                $icon = $route_data[0];
                $route = $route_data[1];

                $menu->add($title, [
                    'id'    => Str::slug($title),
                    'icon'  => $icon,
                    'route' => $route,
                ]);
            }
        }

        return $next($request);
    }
}
