@extends('frontend.layouts.app')
@section('title', 'Galeri')

@section('content')
    @include('frontend.partials.page-hero', ['title' => 'Galeri Kegiatan', 'eyebrow' => 'Informasi', 'lead' => 'Dokumentasi kegiatan, prestasi, dan keseharian warga sekolah.', 'crumbs' => [['Informasi'], ['Galeri']]])

    <section class="py-16 md:py-20" x-data="{ open: null, caption: '' }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($galeris->isEmpty())
                <div class="card p-10 text-center text-slate-500">Belum ada foto galeri.</div>
            @else
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                    @foreach ($galeris as $galeri)
                        @php($url = \App\Support\Media::url($galeri->photo))
                        <figure class="group card overflow-hidden" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 50 }}">
                            <button type="button" class="block w-full overflow-hidden" @if($url) x-on:click="open = @js($url); caption = @js($galeri->judul)" @endif>
                                <x-media :path="$galeri->photo" :alt="$galeri->judul" class="aspect-square w-full transition duration-500 group-hover:scale-105" />
                            </button>
                            <figcaption class="p-4">
                                <p class="line-clamp-2 text-sm font-semibold text-brand-950">{{ $galeri->judul }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $galeri->created_at?->translatedFormat('d F Y') }}</p>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
                <div class="mt-10">{{ $galeris->links() }}</div>
            @endif
        </div>

        <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-[60] flex flex-col items-center justify-center gap-4 bg-brand-950/90 p-4"
             x-on:click="open = null" x-on:keydown.escape.window="open = null">
            <img :src="open" alt="" class="max-h-[80vh] max-w-full rounded-xl shadow-2xl">
            <p class="text-sm font-medium text-white" x-text="caption"></p>
        </div>
    </section>
@endsection
