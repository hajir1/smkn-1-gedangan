<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Kategori;
use App\Support\SiteCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $kategori = $request->query('kategori');

        $artikels = Article::query()
            ->with(['writer:id,name', 'kategoris:id,nama'])
            ->when($search !== '', fn ($q) => $q->where('title', 'like', '%' . addcslashes($search, '%_\\') . '%'))
            ->when($kategori, fn ($q) => $q->whereHas('kategoris', fn ($k) => $k->whereKey($kategori)))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $kategoris = SiteCache::remember('kategoris', fn () => Kategori::query()->orderBy('nama')->get());

        return view('frontend.articles.index', compact('artikels', 'kategoris', 'search', 'kategori'));
    }

    public function show(Request $request, string $slug): View
    {
        $article = Article::query()
            ->with(['writer:id,name', 'kategoris:id,nama'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Hitung 1 view per IP per hari (dulu dikerjakan middleware terpisah
        // yang mengambil artikel dua kali).
        if (Cache::add("article-view:{$article->id}:" . sha1((string) $request->ip()) . ':' . now()->toDateString(), true, now()->endOfDay())) {
            Article::query()->whereKey($article->id)->increment('view');
            $article->view++;
        }

        $related = Article::query()
            ->whereKeyNot($article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.articles.show', compact('article', 'related'));
    }
}
