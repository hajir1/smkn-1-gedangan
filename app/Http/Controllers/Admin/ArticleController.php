<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use App\Models\Kategori;
use App\Services\HtmlSanitizer;
use App\Services\ImageService;
use App\Support\SiteCache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ImageService $images,
        private readonly HtmlSanitizer $sanitizer,
    ) {
    }

    public function index(Request $request): View
    {
        $judul = trim((string) $request->query('judul'));
        $kategoriIds = array_filter((array) $request->query('kategori_id', []), 'is_numeric');

        $articles = Article::query()
            ->with(['kategoris:id,nama', 'writer:id,name'])
            ->when($judul !== '', fn ($q) => $q->where('title', 'like', '%' . addcslashes($judul, '%_\\') . '%'))
            ->when($kategoriIds, fn ($q) => $q->whereHas('kategoris', fn ($k) => $k->whereIn('kategoris.id', $kategoriIds)))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.articles.index', [
            'articles' => $articles,
            'kategoris' => Kategori::query()->orderBy('nama')->get(),
            'judul' => $judul,
            'kategoriIds' => $kategoriIds,
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new Article(),
            'kategoris' => Kategori::query()->orderBy('nama')->get(),
        ]);
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $article = new Article();
        $this->fill($article, $request);
        $article->slug = Article::uniqueSlug($request->validated('title'));
        $article->image = $this->images->store($request->file('image'), 'articles_images');
        $article->save();
        $this->syncKategori($article, $request);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function show(Article $artikel): View
    {
        return view('admin.articles.show', ['article' => $artikel->load('kategoris', 'writer')]);
    }

    public function edit(Article $artikel): View
    {
        return view('admin.articles.form', [
            'article' => $artikel->load('kategoris'),
            'kategoris' => Kategori::query()->orderBy('nama')->get(),
        ]);
    }

    public function update(ArticleRequest $request, Article $artikel): RedirectResponse
    {
        $this->fill($artikel, $request);
        $oldImage = null;

        if ($request->hasFile('image')) {
            $oldImage = $artikel->image;
            $artikel->image = $this->images->store($request->file('image'), 'articles_images');
        }

        $artikel->save();
        $this->images->delete($oldImage);
        $this->syncKategori($artikel, $request);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $artikel): RedirectResponse
    {
        $image = $artikel->image;
        $artikel->delete();
        $this->images->delete($image);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function fill(Article $article, ArticleRequest $request): void
    {
        $article->title = $request->validated('title');
        $article->text_content = $this->sanitizer->clean($request->validated('text_content'));
        $article->writer_id = $request->user()->id;
    }

    private function syncKategori(Article $article, ArticleRequest $request): void
    {
        $article->kategoris()->sync($request->validated('kategori_id'));
        SiteCache::flush(); // perubahan pivot tidak memicu event model
    }
}
