@extends('frontend.layouts.app')
@section('title', 'Berita & Artikel')

@section('content')
    @include('frontend.partials.page-hero', ['title' => 'Berita & Artikel', 'eyebrow' => 'Kabar Sekolah', 'lead' => 'Informasi kegiatan, prestasi, dan pengumuman terbaru dari SMK Negeri 1 Gedangan.', 'crumbs' => [['Informasi'], ['Berita & Artikel']]])

    <section class="py-16 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="card flex flex-col gap-4 p-4 md:flex-row md:items-center md:justify-between" data-aos="fade-up">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('artikel', array_filter(['search' => $search])) }}" class="btn-sm btn {{ ! $kategori ? 'bg-brand-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Semua</a>
                    @foreach ($kategoris as $item)
                        <a href="{{ route('artikel', array_filter(['kategori' => $item->id, 'search' => $search])) }}"
                           class="btn-sm btn capitalize {{ (string) $kategori === (string) $item->id ? 'bg-brand-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">{{ $item->nama }}</a>
                    @endforeach
                </div>
                <form method="GET" action="{{ route('artikel') }}" class="relative md:w-80">
                    @if ($kategori)<input type="hidden" name="kategori" value="{{ $kategori }}">@endif
                    <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari judul artikel..." class="form-input rounded-full pl-10" maxlength="100">
                </form>
            </div>

            @if ($artikels->isEmpty())
                <div class="card mt-10 p-12 text-center">
                    <p class="font-display text-xl font-semibold">Artikel tidak ditemukan</p>
                    <p class="mt-2 text-sm text-slate-500">Coba kata kunci lain atau pilih kategori berbeda.</p>
                </div>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($artikels as $artikel)
                        <a href="{{ route('readArticle', $artikel->slug) }}" class="card card-hover group flex flex-col overflow-hidden" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 60 }}">
                            <div class="relative overflow-hidden">
                                <x-media :path="$artikel->image" :alt="$artikel->title" class="aspect-[16/10] w-full transition duration-700 group-hover:scale-105" />
                                @if ($artikel->kategoris->isNotEmpty())
                                    <span class="chip-gold absolute left-4 top-4 capitalize shadow">{{ $artikel->kategoris->first()->nama }}</span>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                <p class="text-xs font-semibold text-slate-400">{{ $artikel->created_at->translatedFormat('d F Y') }}</p>
                                <h2 class="mt-2 line-clamp-2 font-display text-xl font-semibold leading-snug group-hover:text-brand-700">{{ $artikel->title }}</h2>
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-500">{{ $artikel->excerpt(28) }}</p>
                                <div class="mt-auto flex items-center justify-between pt-5 text-xs text-slate-400">
                                    <span>{{ $artikel->writer?->name ?? 'Admin' }}</span>
                                    <span class="flex items-center gap-1"><x-icon name="eye" class="h-4 w-4" />{{ number_format($artikel->view) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-12">{{ $artikels->links() }}</div>
            @endif
        </div>
    </section>
@endsection
