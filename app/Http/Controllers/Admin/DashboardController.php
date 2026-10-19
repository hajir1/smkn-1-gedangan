<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Masukan;
use App\Models\StatistikPengunjung;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $from = now()->subDays(13)->startOfDay();

        $daily = StatistikPengunjung::query()
            ->where('visited_at', '>=', $from)
            ->get(['visited_at'])
            ->countBy(fn ($row) => $row->visited_at->format('Y-m-d'));

        $chart = collect(CarbonPeriod::create($from, now()->startOfDay()))
            ->map(fn ($day) => ['label' => $day->translatedFormat('d M'), 'value' => $daily[$day->format('Y-m-d')] ?? 0]);

        return view('admin.dashboard', [
            'stats' => [
                'visitors_total' => StatistikPengunjung::query()->count(),
                'visitors_today' => StatistikPengunjung::query()->where('visited_at', '>=', now()->startOfDay())->count(),
                'articles' => Article::query()->count(),
                'gurus' => Guru::query()->count(),
                'galeris' => Galeri::query()->count(),
                'masukans' => Masukan::query()->count(),
            ],
            'chart' => $chart,
            'masukans' => Masukan::query()->latest()->paginate(8),
            'latestArticles' => Article::query()->latest()->take(5)->get(['id', 'title', 'slug', 'view', 'created_at']),
        ]);
    }

    public function destroyFeedback(Masukan $masukan): RedirectResponse
    {
        $masukan->delete();

        return back()->with('success', 'Masukan berhasil dihapus.');
    }
}
