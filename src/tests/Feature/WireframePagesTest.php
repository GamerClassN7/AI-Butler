<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\SettingsSections;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class WireframePagesTest extends TestCase
{
    use RefreshDatabase;

    public static function pages(): array
    {
        return array_map(fn ($route) => [$route], [
            'home', 'assistant.index', 'schedule.index', 'reports.index', 'mail.index', 'tasks.index',
            'knowledge.index', 'knowledge.show', 'feed.index', 'bank.index', 'locations.index',
            'settings.index', 'components.index',
        ]);
    }

    #[DataProvider('pages')]
    public function test_page_renders_with_navigation(string $route): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route($route))
            ->assertOk()
            ->assertSee('layout-nav-mobile', false)
            ->assertSee(route('knowledge.index'), false);
    }

    public function test_every_settings_section_renders(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (array_keys(SettingsSections::all()) as $section) {
            $this->get(route('settings.show', $section))->assertOk()->assertSee(route('settings.show', $section), false);
        }
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('home'))->assertRedirect(route('login'));
    }
}
