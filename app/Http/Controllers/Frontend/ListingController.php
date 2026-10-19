<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Drive;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Kepsek;
use App\Models\Kesiswaan\Prestasi;
use App\Support\SiteCache;
use Illuminate\View\View;

/**
 * Halaman berbentuk daftar. Pagination memakai query database biasa
 * (dulu seluruh tabel diambil lalu dipotong manual di PHP).
 */
class ListingController extends Controller
{
    public function kepsek(): View
    {
        $kepsek = SiteCache::remember('kepsek', fn () => Kepsek::query()->latest()->first());

        return view('frontend.kepsek', compact('kepsek'));
    }

    public function guru(): View
    {
        $gurus = Guru::query()->oldest('nama')->paginate(16);
        $kepsek = SiteCache::remember('kepsek', fn () => Kepsek::query()->latest()->first());

        return view('frontend.guru', compact('gurus', 'kepsek'));
    }

    public function galeri(): View
    {
        $galeris = Galeri::query()->latest()->paginate(12);

        return view('frontend.galeri', compact('galeris'));
    }

    public function drive(): View
    {
        $drives = Drive::query()->latest()->paginate(15);

        return view('frontend.drive', compact('drives'));
    }

    public function prestasi(): View
    {
        $prestasis = Prestasi::query()->latest()->paginate(15);

        return view('frontend.prestasi', compact('prestasis'));
    }
}
