<?php

namespace App\Http\Controllers\Frontend;

use App\Cms\Registry;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Kepsek;
use App\Models\Profil;
use App\Models\Profil\Waka;
use App\Support\SiteCache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $data = SiteCache::remember('home', function () {
            $jurusan = collect(Registry::JURUSAN)->map(function (array $item, string $key) {
                [$model, $label] = $item;
                $record = $model::query()->select(['id', 'judul', 'photo'])->first();

                return (object) ['key' => $key, 'label' => $label, 'judul' => $record?->judul, 'photo' => $record?->photo];
            })->values();

            return [
                'profil' => Profil::query()->first(),
                'kepsek' => Kepsek::query()->latest()->first(),
                'wakas' => Waka::query()->oldest()->take(12)->get(),
                'articles' => Article::query()->with('writer:id,name')->prestasi(false)->latest()->take(4)->get(),
                'prestasis' => Article::query()->prestasi()->latest()->take(4)->get(),
                'galeris' => Galeri::query()->latest()->take(6)->get(),
                'jurusan' => $jurusan,
                'stats' => [
                    'jurusan' => count(Registry::JURUSAN),
                    'guru' => Guru::query()->count(),
                    'artikel' => Article::query()->count(),
                    'tahun' => now()->year - (int) config('school.founded'),
                ],
            ];
        }, 60 * 60);

        return view('frontend.home', $data);
    }
}
