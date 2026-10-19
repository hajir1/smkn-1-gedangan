@extends('frontend.layouts.app')
@section('title', 'Sambutan Kepala Sekolah')

@section('content')
    @include('frontend.partials.page-hero', ['title' => 'Sambutan Kepala Sekolah', 'eyebrow' => 'Profil', 'crumbs' => [['Profil'], ['Sambutan Kepala Sekolah']]])

    <section class="py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <article class="card min-w-0 overflow-hidden lg:col-span-8" data-aos="fade-up">
                @if ($kepsek)
                    <div class="grid gap-8 p-6 sm:p-10 md:grid-cols-[14rem_1fr]">
                        <div>
                            <x-media :path="$kepsek->photo" :alt="$kepsek->nama" class="aspect-[3/4] w-full rounded-2xl object-top" icon="user" />
                            <p class="mt-4 font-display text-xl font-semibold text-brand-950">{{ $kepsek->nama }}</p>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-600">Kepala Sekolah</p>
                        </div>
                        <div>
                            <x-icon name="quote" class="h-10 w-10 text-gold-400" />
                            <div class="richtext mt-2">{!! $kepsek->sambutan !!}</div>
                        </div>
                    </div>
                @else
                    <p class="p-10 text-center text-slate-500">Sambutan belum tersedia.</p>
                @endif
            </article>
            <div class="lg:col-span-4">@include('frontend.partials.sidebar')</div>
        </div>
    </section>
@endsection
