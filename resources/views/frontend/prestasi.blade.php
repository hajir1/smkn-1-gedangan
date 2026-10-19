@extends('frontend.layouts.app')
@section('title', 'Prestasi Siswa')

@section('content')
    @include('frontend.partials.page-hero', ['title' => 'Prestasi Siswa', 'eyebrow' => 'Kesiswaan', 'lead' => 'Capaian siswa SMK Negeri 1 Gedangan di berbagai ajang dan tingkat kompetisi.', 'crumbs' => [['Kesiswaan'], ['Prestasi']]])

    <section class="py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <div class="min-w-0 lg:col-span-8">
                @if ($prestasis->isEmpty())
                    <div class="card p-10 text-center text-slate-500">Data prestasi belum tersedia.</div>
                @else
                    <ol class="space-y-4">
                        @foreach ($prestasis as $prestasi)
                            <li class="card flex items-start gap-4 p-5" data-aos="fade-up">
                                <span class="grid h-12 w-12 shrink-0 place-content-center rounded-full bg-gold-100 text-gold-700"><x-icon name="trophy" class="h-6 w-6" /></span>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-brand-950">{{ $prestasi->nama }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $prestasi->penyelenggara }}</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="chip-gold">{{ $prestasi->juara }}</span>
                                        <span class="chip">Tingkat {{ $prestasi->tingkat }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                    <div class="mt-8">{{ $prestasis->links() }}</div>
                @endif
            </div>
            <div class="lg:col-span-4">@include('frontend.partials.sidebar')</div>
        </div>
    </section>
@endsection
