@extends('frontend.layouts.app')

@section('title', 'Beranda')

@php
    $slides = [
        ['lg' => 'img/welcome/static_baner3.jpg', 'sm' => 'img/welcome/static_sm_baner3.jpg'],
        ['lg' => 'img/welcome/static_baner1.jpg', 'sm' => 'img/welcome/static_sm_baner_1.jpg'],
        ['lg' => 'img/welcome/static_baner2.jpg', 'sm' => 'img/welcome/static_sm_baner2.jpg'],
    ];
@endphp

@section('content')
    {{-- ============ HERO ============ --}}
    <section x-data="{ active: 0, total: {{ count($slides) }} }"
             x-init="setInterval(() => active = (active + 1) % total, 6000)"
             class="relative flex min-h-[100svh] items-end overflow-hidden bg-brand-950 pb-20 pt-40 md:items-center md:pb-24">
        @foreach ($slides as $i => $slide)
            <picture x-show="active === {{ $i }}" x-transition:enter="transition-opacity duration-[1500ms]" x-transition:enter-start="opacity-0"
                     x-transition:leave="transition-opacity duration-[1500ms]" x-transition:leave-end="opacity-0"
                     class="absolute inset-0" @if($i) x-cloak @endif>
                <source media="(max-width: 640px)" srcset="{{ asset($slide['sm']) }}">
                <img src="{{ asset($slide['lg']) }}" alt="" class="h-full w-full scale-105 object-cover" @if($i) loading="lazy" @endif>
            </picture>
        @endforeach
        <div class="absolute inset-0 bg-gradient-to-r from-brand-950/95 via-brand-950/70 to-brand-950/20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-950 via-transparent to-brand-950/40"></div>

        <div class="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="eyebrow !text-gold-300 before:!bg-gold-300" data-aos="fade-up">Sekolah Menengah Kejuruan Negeri</p>
                <h1 class="mt-5 font-display text-[2.6rem] font-semibold leading-[1.05] tracking-tight !text-white sm:text-6xl lg:text-7xl" data-aos="fade-up" data-aos-delay="80">
                    Selamat datang di <span class="italic text-gold-300">SMK Negeri 1</span> Gedangan
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-relaxed text-brand-100/85 sm:text-lg" data-aos="fade-up" data-aos-delay="160">
                    {{ config('school.tagline') }}
                </p>
                <div class="mt-9 flex flex-wrap gap-3" data-aos="fade-up" data-aos-delay="220">
                    <a href="#jurusan" class="btn-gold">Jelajahi Program Keahlian <x-icon name="arrow-right" class="h-4 w-4" /></a>
                    <a href="{{ route('info_ppdb') }}" class="btn-ghost-light">Informasi PPDB</a>
                </div>
            </div>

            <div class="mt-14 flex items-center gap-2" aria-hidden="true">
                @foreach ($slides as $i => $slide)
                    <button type="button" x-on:click="active = {{ $i }}" class="h-1.5 rounded-full transition-all duration-500"
                            :class="active === {{ $i }} ? 'w-10 bg-gold-400' : 'w-4 bg-white/40 hover:bg-white/70'"></button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ STATISTIK ============ --}}
    <section class="relative z-10 -mt-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <dl class="card grid grid-cols-2 divide-slate-100 overflow-hidden md:grid-cols-4 md:divide-x" data-aos="fade-up">
                @foreach ([
                    ['value' => $stats['jurusan'], 'label' => 'Program Keahlian', 'icon' => 'academic'],
                    ['value' => $stats['guru'] ?: '—', 'label' => 'Guru & Tendik', 'icon' => 'users'],
                    ['value' => $stats['artikel'] ?: '—', 'label' => 'Berita & Kegiatan', 'icon' => 'document'],
                    ['value' => $stats['tahun'] . '+', 'label' => 'Tahun Berkarya', 'icon' => 'sparkles'],
                ] as $stat)
                    <div class="flex items-center gap-4 p-5 md:p-7">
                        <span class="grid h-12 w-12 shrink-0 place-content-center rounded-xl bg-brand-50 text-brand-700"><x-icon :name="$stat['icon']" class="h-6 w-6" /></span>
                        <div>
                            <dd class="font-display text-3xl font-semibold text-brand-950">{{ $stat['value'] }}</dd>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $stat['label'] }}</dt>
                        </div>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- ============ PROFIL & SAMBUTAN ============ --}}
    <section id="profil" class="py-24">
        <div class="mx-auto grid max-w-7xl items-start gap-14 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <div class="lg:col-span-7" data-aos="fade-up">
                <p class="eyebrow">Profil Sekolah</p>
                <h2 class="section-title mt-3">Membentuk generasi kompeten, mandiri, dan berakhlak</h2>
                <div class="relative mt-8">
                    <x-media :path="$profil?->photo" alt="Profil SMK Negeri 1 Gedangan" class="aspect-[16/9] w-full rounded-3xl" icon="building" />
                    <div class="absolute -bottom-5 -right-3 hidden rounded-2xl bg-gold-400 px-5 py-4 text-brand-950 shadow-xl sm:block">
                        <p class="font-display text-2xl font-semibold">Sejak {{ config('school.founded') }}</p>
                        <p class="text-xs font-semibold uppercase tracking-wider">{{ config('school.city') }}</p>
                    </div>
                </div>
                @if ($profil)
                    <div class="richtext mt-10 line-clamp-[10]">{!! $profil->konten !!}</div>
                @endif
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('sejarah') }}" class="btn-primary">Sejarah Sekolah <x-icon name="arrow-right" class="h-4 w-4" /></a>
                    <a href="{{ route('visi') }}" class="btn-outline">Visi & Misi</a>
                </div>
            </div>

            <div class="space-y-8 lg:col-span-5">
                @if ($kepsek)
                    <article class="card overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                        <div class="relative">
                            <x-media :path="$kepsek->photo" :alt="$kepsek->nama" class="aspect-[4/4] w-full object-top" icon="user" />
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-brand-950 via-brand-950/70 to-transparent p-6 pt-20">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Kepala Sekolah</p>
                                <h3 class="mt-1 font-display text-2xl font-semibold !text-white">{{ $kepsek->nama }}</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <x-icon name="quote" class="h-8 w-8 text-gold-400" />
                            <p class="mt-2 font-display text-lg italic leading-relaxed text-brand-900">
                                {{ \Illuminate\Support\Str::words(trim(html_entity_decode(strip_tags($kepsek->sambutan))), 32) }}
                            </p>
                            <a href="{{ route('sambutan_kepsek') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-900">
                                Baca sambutan lengkap <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                        </div>
                    </article>
                @endif

                @if ($prestasis->isNotEmpty())
                    <div class="card p-6" data-aos="fade-up" data-aos-delay="150">
                        <div class="flex items-center justify-between">
                            <h3 class="flex items-center gap-2 font-display text-xl font-semibold"><x-icon name="trophy" class="h-5 w-5 text-gold-500" />Prestasi Terbaru</h3>
                            <a href="{{ route('prestasi') }}" class="text-xs font-semibold text-brand-700">Semua</a>
                        </div>
                        <ul class="mt-4 divide-y divide-slate-100">
                            @foreach ($prestasis as $prestasi)
                                <li>
                                    <a href="{{ route('readArticle', $prestasi->slug) }}" class="group flex items-center gap-4 py-3">
                                        <x-media :path="$prestasi->image" :alt="$prestasi->title" class="h-14 w-14 shrink-0 rounded-xl" icon="trophy" />
                                        <span>
                                            <span class="line-clamp-2 text-sm font-semibold text-brand-950 group-hover:text-brand-700">{{ $prestasi->title }}</span>
                                            <span class="text-xs text-slate-400">{{ $prestasi->created_at->translatedFormat('d F Y') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ PROGRAM KEAHLIAN ============ --}}
    <section id="jurusan" class="bg-white py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                <div data-aos="fade-up">
                    <p class="eyebrow">Program Keahlian</p>
                    <h2 class="section-title mt-3">Pilih jalur menuju dunia kerja</h2>
                    <p class="section-lead">Setiap program dirancang bersama dunia usaha dan industri agar lulusan siap bekerja, melanjutkan studi, atau berwirausaha.</p>
                </div>
            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($jurusan as $i => $item)
                    <a href="{{ route($item->key) }}" class="card card-hover group relative overflow-hidden {{ $i === 0 ? 'sm:col-span-2 lg:row-span-2' : '' }}"
                       data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 60 }}">
                        <x-media :path="$item->photo" :alt="$item->label" class="{{ $i === 0 ? 'aspect-[4/3] lg:aspect-auto lg:h-full' : 'aspect-[4/3]' }} w-full transition duration-700 group-hover:scale-105" icon="academic" />
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/95 via-brand-950/30 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-5">
                            <span class="chip-gold uppercase">{{ $item->key }}</span>
                            <h3 class="mt-2 font-display {{ $i === 0 ? 'text-2xl md:text-3xl' : 'text-lg' }} font-semibold leading-snug !text-white">{{ $item->label }}</h3>
                            <span class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-gold-300 opacity-0 transition group-hover:opacity-100">
                                Lihat program <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ PIMPINAN ============ --}}
    @if ($wakas->isNotEmpty())
        <section class="py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center" data-aos="fade-up">
                    <p class="eyebrow">Pimpinan Sekolah</p>
                    <h2 class="section-title mt-3">Wakil Kepala Sekolah</h2>
                </div>
                <div class="mt-12 flex snap-x gap-5 overflow-x-auto pb-4 [scrollbar-width:thin] lg:grid lg:grid-cols-4 lg:overflow-visible">
                    @foreach ($wakas as $waka)
                        <figure class="card w-60 shrink-0 snap-start overflow-hidden lg:w-auto" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 60 }}">
                            <x-media :path="$waka->photo" :alt="$waka->nama" class="aspect-[4/5] w-full object-top" icon="user" />
                            <figcaption class="border-t-2 border-gold-400 p-4 text-center">
                                <p class="font-semibold capitalize text-brand-950">{{ $waka->nama }}</p>
                                <p class="mt-0.5 text-xs capitalize text-slate-500">{{ $waka->jabatan }}</p>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ BERITA ============ --}}
    @if ($articles->isNotEmpty())
        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4" data-aos="fade-up">
                    <div>
                        <p class="eyebrow">Kabar Sekolah</p>
                        <h2 class="section-title mt-3">Berita & Artikel Terbaru</h2>
                    </div>
                    <a href="{{ route('artikel') }}" class="btn-outline">Semua Berita <x-icon name="arrow-right" class="h-4 w-4" /></a>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-2">
                    @foreach ($articles as $article)
                        @if ($loop->first)
                            <a href="{{ route('readArticle', $article->slug) }}" class="card card-hover group overflow-hidden lg:row-span-3" data-aos="fade-up">
                                <x-media :path="$article->image" :alt="$article->title" class="aspect-[16/10] w-full" />
                                <div class="p-6 md:p-8">
                                    <p class="flex items-center gap-2 text-xs font-semibold text-slate-400"><x-icon name="calendar" class="h-4 w-4" />{{ $article->created_at->translatedFormat('d F Y') }}</p>
                                    <h3 class="mt-3 font-display text-2xl font-semibold leading-snug group-hover:text-brand-700">{{ $article->title }}</h3>
                                    <p class="mt-3 text-sm leading-relaxed text-slate-500">{{ $article->excerpt(35) }}</p>
                                    <p class="mt-5 flex items-center gap-4 text-xs text-slate-400">
                                        <span class="flex items-center gap-1.5"><x-icon name="user" class="h-4 w-4" />{{ $article->writer?->name ?? 'Admin' }}</span>
                                        <span class="flex items-center gap-1.5"><x-icon name="eye" class="h-4 w-4" />{{ number_format($article->view) }} kali dibaca</span>
                                    </p>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('readArticle', $article->slug) }}" class="card card-hover group flex gap-5 overflow-hidden p-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                                <x-media :path="$article->image" :alt="$article->title" class="h-28 w-36 shrink-0 rounded-xl sm:w-44" />
                                <div class="py-1">
                                    <p class="text-xs font-semibold text-slate-400">{{ $article->created_at->translatedFormat('d F Y') }}</p>
                                    <h3 class="mt-1.5 line-clamp-2 font-semibold leading-snug text-brand-950 group-hover:text-brand-700">{{ $article->title }}</h3>
                                    <p class="mt-2 line-clamp-2 text-sm text-slate-500">{{ $article->excerpt(18) }}</p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ GALERI ============ --}}
    @if ($galeris->isNotEmpty())
        <section class="py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4" data-aos="fade-up">
                    <div>
                        <p class="eyebrow">Galeri</p>
                        <h2 class="section-title mt-3">Momen di SMKN 1 Gedangan</h2>
                    </div>
                    <a href="{{ route('galeri') }}" class="btn-outline">Lihat Galeri <x-icon name="arrow-right" class="h-4 w-4" /></a>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-3 md:grid-cols-4 md:grid-rows-2">
                    @foreach ($galeris as $galeri)
                        <figure class="group relative overflow-hidden rounded-2xl {{ $loop->first ? 'col-span-2 row-span-2' : '' }}" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                            <x-media :path="$galeri->photo" :alt="$galeri->judul" class="h-full min-h-40 w-full transition duration-700 group-hover:scale-105" />
                            <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-brand-950/90 to-transparent p-4 pt-10 text-sm font-semibold text-white opacity-0 transition group-hover:opacity-100">
                                {{ $galeri->judul }}
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
