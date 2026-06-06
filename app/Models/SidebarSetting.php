<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SidebarSetting extends Model
{
    /** Roles that always see every feature, regardless of visibility settings. */
    private const SUPER_ROLES = ['super-admin'];

    protected $fillable = [
        'menu_key',
        'label',
        'icon',
        'route',
        'roles_visible',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'roles_visible' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * All sidebar settings keyed by their menu_key (cached).
     */
    public static function cached(): Collection
    {
        return Cache::rememberForever('sidebar.settings', function () {
            return static::query()->orderBy('sort_order')->get()->keyBy('menu_key');
        });
    }

    /**
     * Active menus visible to the given role, ordered by sort_order.
     */
    public static function forRole(?string $role): Collection
    {
        if (! $role) {
            return collect();
        }

        return static::cached()
            ->filter(fn (self $item) => $item->is_active && static::roleCanSee($item, $role))
            ->values();
    }

    /**
     * Determine whether a feature (by menu_key) is visible for the given role.
     *
     * Super-admin always sees everything. Unconfigured keys default to visible
     * so newly added features are not hidden until the admin configures them.
     */
    public static function allowed(string $menuKey, ?string $role): bool
    {
        if ($role && in_array($role, self::SUPER_ROLES, true)) {
            return true;
        }

        if (! $role) {
            return false;
        }

        $menu = static::cached()->get($menuKey);

        if (! $menu) {
            return true;
        }

        return $menu->is_active && static::roleCanSee($menu, $role);
    }

    private static function roleCanSee(self $menu, string $role): bool
    {
        if (in_array($role, self::SUPER_ROLES, true)) {
            return true;
        }

        return in_array($role, $menu->roles_visible ?? [], true);
    }

    public static function clearCache(): void
    {
        Cache::forget('sidebar.settings');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }
}
