<?php

namespace App\Models\Concerns;

use App\Support\SiteCache;

/**
 * Pasang trait ini pada model yang tampil di website publik supaya cache
 * otomatis diperbarui setiap kali data disimpan atau dihapus.
 */
trait FlushesSiteCache
{
    public static function bootFlushesSiteCache(): void
    {
        static::saved(fn () => SiteCache::flush());
        static::deleted(fn () => SiteCache::flush());
    }
}
