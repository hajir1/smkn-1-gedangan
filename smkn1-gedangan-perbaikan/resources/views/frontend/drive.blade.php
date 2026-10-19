@extends('frontend.layouts.app')
@section('title', 'Drive Dokumen')

@section('content')
    @include('frontend.partials.page-hero', ['title' => 'Drive Dokumen', 'eyebrow' => 'Informasi', 'lead' => 'Kumpulan tautan dokumen dan berkas resmi sekolah.', 'crumbs' => [['Informasi'], ['Drive']]])

    <section class="py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <div class="min-w-0 lg:col-span-8">
                <div class="card divide-y divide-slate-100" data-aos="fade-up">
                    @forelse ($drives as $drive)
                        <a href="{{ $drive->link }}" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-4 p-5 transition hover:bg-brand-50/50">
                            <span class="grid h-11 w-11 shrink-0 place-content-center rounded-xl bg-brand-50 text-brand-700 group-hover:bg-brand-800 group-hover:text-gold-300"><x-icon name="folder" /></span>
                            <span class="min-w-0 flex-1">
                                <span class="block font-semibold text-brand-950">{{ $drive->judul }}</span>
                                <span class="block truncate text-xs text-slate-400">{{ parse_url($drive->link, PHP_URL_HOST) }}</span>
                            </span>
                            <x-icon name="external" class="h-4 w-4 text-slate-300 group-hover:text-brand-700" />
                        </a>
                    @empty
                        <p class="p-10 text-center text-slate-500">Belum ada dokumen.</p>
                    @endforelse
                </div>
                <div class="mt-8">{{ $drives->links() }}</div>
            </div>
            <div class="lg:col-span-4">@include('frontend.partials.sidebar')</div>
        </div>
    </section>
@endsection
