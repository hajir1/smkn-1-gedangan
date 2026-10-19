<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\Cache;

/**
 * Cache konten publik website.
 *
 * Semua key diberi prefix "versi". Ketika ada data yang berubah, cukup panggil
 * SiteCache::flush() untuk menaikkan versi sehingga seluruh cache lama otomatis
 * tidak terpakai lagi. Dengan begitu kita tidak perlu lagi menghapus key satu
 * per satu (sumber banyak bug cache basi sebelumnya).
 */
class SiteCache
{
    private const VERSION_KEY = 'site-cache:version';

    public static function remember(string $key, Closure $callback, ?int $seconds = null): mixed
    {
        return Cache::remember(self::key($key), $seconds ?? 60 * 60 * 24 * 7, $callback);
    }

    public static function key(string $key): string
    {
        return 'site:v' . Cache::get(self::VERSION_KEY, 1) . ':' . $key;
    }

    public static function flush(): void
    {
        Cache::forever(self::VERSION_KEY, ((int) Cache::get(self::VERSION_KEY, 1)) + 1);
    }
}
