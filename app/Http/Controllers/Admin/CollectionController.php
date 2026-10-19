<?php

namespace App\Http\Controllers\Admin;

use App\Cms\ContentWriter;
use App\Cms\Registry;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CRUD untuk semua data berbentuk daftar (Guru, Galeri, Prestasi, Drive, Waka,
 * Komite, Pengurus OSIS, foto Ekstrakurikuler & Bisnis).
 */
class CollectionController extends Controller
{
    public function __construct(private readonly ContentWriter $writer)
    {
    }

    public function index(Request $request, string $collection): View
    {
        $collection = Registry::collection($collection);
        $search = trim((string) $request->query('q'));
        $searchable = $collection->textFields()[0]->name ?? null;

        $items = $collection->model::query()
            ->when($search !== '' && $searchable, fn ($q) => $q->where($searchable, 'like', '%' . addcslashes($search, '%_\\') . '%'))
            ->latest()
            ->paginate($collection->layout === 'cards' ? 12 : 15)
            ->withQueryString();

        return view('admin.collections.index', compact('collection', 'items', 'search'));
    }

    public function create(string $collection): View
    {
        $collection = Registry::collection($collection);

        return view('admin.collections.form', ['collection' => $collection, 'record' => new $collection->model()]);
    }

    public function store(Request $request, string $collection): RedirectResponse
    {
        $collection = Registry::collection($collection);
        $this->writer->save(new $collection->model(), $collection->fields, $request);

        return $this->backToIndex($collection->key, "{$collection->singular} berhasil ditambahkan.");
    }

    public function edit(string $collection, int $id): View
    {
        $collection = Registry::collection($collection);

        return view('admin.collections.form', ['collection' => $collection, 'record' => $collection->find($id)]);
    }

    public function update(Request $request, string $collection, int $id): RedirectResponse
    {
        $collection = Registry::collection($collection);
        $this->writer->save($collection->find($id), $collection->fields, $request);

        return $this->backToIndex($collection->key, "{$collection->singular} berhasil diperbarui.");
    }

    public function destroy(string $collection, int $id): RedirectResponse
    {
        $collection = Registry::collection($collection);
        $this->writer->delete($collection->find($id), $collection->fields);

        return $this->backToIndex($collection->key, "{$collection->singular} berhasil dihapus.");
    }

    private function backToIndex(string $key, string $message): RedirectResponse
    {
        return redirect()->route('admin.collections.index', $key)->with('success', $message);
    }
}
