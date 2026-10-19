@extends('frontend.layouts.app')
@section('title', 'Guru & Tenaga Kependidikan')

@section('content')
    @include('frontend.partials.page-hero', [
        'title' => 'Guru & Tenaga Kependidikan',
        'eyebrow' => 'Informasi',
        'lead' => 'Para pendidik yang mendampingi siswa SMK Negeri 1 Gedangan setiap hari.',
        'crumbs' => [['Informasi'], ['Guru & Tendik']],
    ])

    <section class="py-16 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($kepsek)
                <div class="card mb-12 flex flex-col items-center gap-6 overflow-hidden p-6 sm:flex-row sm:p-8" data-aos="fade-up">
                    <x-media :path="$kepsek->photo" :alt="$kepsek->nama" class="h-36 w-28 shrink-0 rounded-2xl object-top" icon="user" />
                    <div class="flex-1 text-center sm:text-left">
                        <p class="eyebrow">Kepala Sekolah</p>
                        <p class="mt-2 font-display text-2xl font-semibold">{{ $kepsek->nama }}</p>
                        <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::words(trim(html_entity_decode(strip_tags($kepsek->sambutan))), 28) }}</p>
                    </div>
                    <a href="{{ route('sambutan_kepsek') }}" class="btn-outline shrink-0">Baca Sambutan</a>
                </div>
            @endif

            @if ($gurus->isEmpty())
                <div class="card p-10 text-center text-slate-500">Data guru belum tersedia.</div>
            @else
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($gurus as $guru)
                        <figure class="card card-hover overflow-hidden" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 50 }}">
                            <x-media :path="$guru->photo" :alt="$guru->nama" class="aspect-[4/5] w-full object-top" icon="user" />
                            <figcaption class="border-t-2 border-gold-400 p-4 text-center">
                                <p class="font-semibold text-brand-950">{{ $guru->nama }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">{{ $guru->tugas }}</p>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
                <div class="mt-10">{{ $gurus->links() }}</div>
            @endif
        </div>
    </section>
@endsection
