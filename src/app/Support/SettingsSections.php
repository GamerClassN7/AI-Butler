<?php

namespace App\Support;

/**
 * Settings sub-pages – single source for the desktop sub-navigation and the mobile hub (/nastaveni).
 * Each key has a view in resources/views/pages/settings/{key}.blade.php.
 */
class SettingsSections
{
    /** @return array<string, array{label: string, icon: string, description: string}> */
    public static function all(): array
    {
        return [
            'connectors'    => ['label' => 'Konektory', 'icon' => 'fas fa-plug', 'description' => 'Pošta, kalendáře, pracovní nástroje a bankovní výpisy'],
            'webhooks'      => ['label' => 'Webhooky', 'icon' => 'fas fa-bolt', 'description' => 'Odchozí HTTP POST při událostech'],
            'worklog'       => ['label' => 'Worklog', 'icon' => 'fas fa-clock', 'description' => 'Pracovní doba a zákazníci'],
            'finance'       => ['label' => 'Finance', 'icon' => 'fas fa-coins', 'description' => 'Měsíční cíl, kategorie a pravidla plateb'],
            'geolocation'   => ['label' => 'Geolokace', 'icon' => 'fas fa-location-dot', 'description' => 'Sběr polohy a zóny'],
            'ai-models'     => ['label' => 'AI modely', 'icon' => 'fas fa-microchip', 'description' => 'Poskytovatelé a klíče'],
            'ai-jobs'       => ['label' => 'AI joby', 'icon' => 'fas fa-wand-magic-sparkles', 'description' => 'Která úloha běží na kterém modelu'],
            'knowledge'     => ['label' => 'Znalosti', 'icon' => 'fas fa-brain', 'description' => 'Přístup agentů a vyhledávání'],
            'notifications' => ['label' => 'Notifikace', 'icon' => 'fas fa-bell', 'description' => 'Co chodí pushem a co e-mailem'],
            'app'           => ['label' => 'Aplikace', 'icon' => 'fas fa-mobile-screen', 'description' => 'Instalace a push na tomto zařízení'],
            'logging'       => ['label' => 'Logování', 'icon' => 'fas fa-file-lines', 'description' => 'Uchování záznamů'],
        ];
    }

    /** Sections needing attention (e.g. a connector with an expired token) – wireframe data. */
    public static function badges(): array
    {
        return ['connectors' => 1];
    }
}
