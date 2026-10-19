<?php

namespace App\Http\Controllers\Frontend;

use App\Cms\Registry;
use App\Http\Controllers\Controller;
use App\Support\SiteCache;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menampilkan semua halaman konten tunggal (Sejarah, Visi Misi, Jurusan, dst).
 * Menggantikan 25+ method yang isinya sama di FrontendController lama.
 */
class PageController extends Controller
{
    public function __invoke(Request $request): View
    {
        $section = Registry::section($request->route()->defaults['section']);

        $data = SiteCache::remember('page:' . $section->key, fn () => [
            'record' => $section->model::query()->with($this->authorRelation($section->model))->first(),
            'related' => $section->relatedData(),
        ]);

        return view('frontend.page', [
            'section' => $section,
            'record' => $data['record'],
            'related' => $data['related'],
        ]);
    }

    private function authorRelation(string $model): array
    {
        return method_exists($model, 'penulis') ? ['penulis:id,name'] : [];
    }
}
