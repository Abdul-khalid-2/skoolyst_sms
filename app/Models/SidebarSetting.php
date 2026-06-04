<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SidebarSetting extends Model
{
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

    public static function forRole(?string $role): Collection
    {
        return Cache::rememberForever('sidebar.settings', function () {
            return static::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        })->filter(function (self $item) use ($role) {
            if (! $role) {
                return false;
            }

            return in_array($role, $item->roles_visible ?? [], true);
        })->values();
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
