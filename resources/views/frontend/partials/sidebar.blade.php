@php
    $sidebar = \App\Support\SiteCache::remember('sidebar', fn () => [
        'articles' => \App\Models\Article::query()->latest()->take(4)->get(['id', 'title', 'slug', 'image', 'created_at']),
        'galeris' => \App\Models\Galeri::query()->latest()->take(4)->get(['id', 'judul', 'photo']),
    ]);
@endphp
<aside class="space-y-6 lg:sticky lg:top-28">
    @if ($sidebar['articles']->isNotEmpty())
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-semibold">Berita Terbaru</h2>
                <a href="{{ route('artikel') }}" class="text-xs font-semibold text-brand-700 hover:text-brand-900">Semua</a>
            </div>
            <ul class="mt-4 space-y-4">
                @foreach ($sidebar['articles'] as $item)
                    <li>
                        <a href="{{ route('readArticle', $item->slug) }}" class="group flex gap-3">
                            <x-media :path="$item->image" :alt="$item->title" class="h-16 w-20 shrink-0 rounded-lg" />
                            <span>
                                <span class="line-clamp-2 text-sm font-semibold leading-snug text-brand-950 group-hover:text-brand-700">{{ $item->title }}</span>
                                <span class="mt-1 block text-xs text-slate-400">{{ $item->created_at->translatedFormat('d F Y') }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($sidebar['galeris']->isNotEmpty())
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-semibold">Galeri</h2>
                <a href="{{ route('galeri') }}" class="text-xs font-semibold text-brand-700 hover:text-brand-900">Lihat</a>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-2">
                @foreach ($sidebar['galeris'] as $galeri)
                    <a href="{{ route('galeri') }}" class="group relative overflow-hidden rounded-lg">
                        <x-media :path="$galeri->photo" :alt="$galeri->judul" class="aspect-square w-full transition duration-500 group-hover:scale-105" />
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="relative overflow-hidden rounded-2xl bg-brand-900 p-6 text-white">
        <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gold-400/20 blur-2xl"></div>
        <p class="eyebrow !text-gold-300 before:!bg-gold-300">PPDB</p>
        <p class="mt-2 font-display text-xl font-semibold !text-white">Bergabung bersama SMKN 1 Gedangan</p>
        <p class="mt-2 text-sm text-brand-100/80">Temukan informasi pendaftaran peserta didik baru dan pilih program keahlianmu.</p>
        <a href="{{ route('info_ppdb') }}" class="btn-gold btn-sm mt-4">Info PPDB <x-icon name="arrow-right" class="h-4 w-4" /></a>
    </div>
</aside>
