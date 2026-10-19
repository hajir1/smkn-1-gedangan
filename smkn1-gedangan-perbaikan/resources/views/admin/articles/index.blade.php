@extends('admin.layouts.app')
@section('title', 'Berita & Artikel')
@section('eyebrow', 'Konten')

@section('content')
    <form method="GET" class="card flex flex-col gap-4 p-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap items-center gap-2">
            <div class="relative">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                <input type="search" name="judul" value="{{ $judul }}" placeholder="Cari judul..." class="form-input w-64 rounded-full py-2 pl-9">
            </div>
            @foreach ($kategoris as $kategori)
                <label class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold capitalize text-slate-600 has-[:checked]:bg-brand-800 has-[:checked]:text-white">
                    <input type="checkbox" name="kategori_id[]" value="{{ $kategori->id }}" class="sr-only" @checked(in_array($kategori->id, $kategoriIds)) onchange="this.form.submit()">
                    {{ $kategori->nama }}
                </label>
            @endforeach
            @if ($judul || $kategoriIds)
                <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-rose-600 hover:underline">Reset</a>
            @endif
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn-primary btn-sm"><x-icon name="plus" class="h-4 w-4" />Tulis Artikel</a>
    </form>

    <div class="card mt-6 overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Artikel</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th class="text-right">Dibaca</th>
                    <th class="w-32 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <x-media :path="$article->image" alt="" class="h-12 w-16 shrink-0 rounded-lg" />
                                <div class="min-w-0">
                                    <a href="{{ route('admin.articles.show', $article) }}" class="line-clamp-1 font-semibold text-brand-950 hover:text-brand-700">{{ $article->title }}</a>
                                    <p class="text-xs text-slate-400">{{ $article->created_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-wrap gap-1">
                                @foreach ($article->kategoris as $kategori)<span class="chip capitalize">{{ $kategori->nama }}</span>@endforeach
                            </div>
                        </td>
                        <td class="text-slate-500">{{ $article->writer?->name ?? '-' }}</td>
                        <td class="text-right font-medium">{{ number_format($article->view) }}</td>
                        <td class="text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('readArticle', $article->slug) }}" target="_blank" rel="noopener" class="grid h-8 w-8 place-content-center rounded-lg text-slate-500 hover:bg-brand-50" aria-label="Lihat"><x-icon name="external" class="h-4 w-4" /></a>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="grid h-8 w-8 place-content-center rounded-lg text-slate-500 hover:bg-brand-50 hover:text-brand-800" aria-label="Ubah"><x-icon name="pencil" class="h-4 w-4" /></a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" data-confirm="Artikel “{{ \Illuminate\Support\Str::limit($article->title, 50) }}” akan dihapus permanen.">
                                    @csrf @method('DELETE')
                                    <button class="grid h-8 w-8 place-content-center rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600" aria-label="Hapus"><x-icon name="trash" class="h-4 w-4" /></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-12 text-center text-slate-400">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $articles->links() }}</div>
@endsection
