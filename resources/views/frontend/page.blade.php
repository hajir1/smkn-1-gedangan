@extends('frontend.layouts.app')

@php
    $title = $section->titleField() && $record?->judul ? \Illuminate\Support\Str::title($record->judul) : $section->label;
    $image = collect($section->fields)->first(fn ($f) => $f->isImage() && $f->name === 'photo');
@endphp

@section('title', $title)
@section('description', $record?->konten ? \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags($record->konten))), 155) : config('school.tagline'))

@section('content')
    @include('frontend.partials.page-hero', [
        'title' => $title,
        'eyebrow' => $section->group,
        'crumbs' => [[$section->group], [$section->label]],
    ])

    <section class="py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <div class="min-w-0 lg:col-span-8">
                @if (! $record)
                    <div class="card p-10 text-center text-slate-500">Konten halaman ini belum tersedia.</div>
                @else
                    <article class="card overflow-hidden" data-aos="fade-up">
                        @if ($image && $section->partial !== 'jurusan')
                            <x-media :path="$record->photo" :alt="$title" class="max-h-[32rem] w-full {{ $section->key === 'logo' ? 'object-contain bg-white p-8' : '' }}" />
                        @endif

                        @if ($section->partial === 'jurusan')
                            @include('frontend.sections.jurusan')
                        @endif

                        <div class="p-6 sm:p-10">
                            <div class="richtext">{!! $record->konten !!}</div>

                            @if ($record->updated_at)
                                <p class="mt-10 flex flex-wrap items-center gap-x-4 gap-y-1 border-t border-slate-100 pt-5 text-xs text-slate-400">
                                    @if ($record->penulis ?? null)
                                        <span class="flex items-center gap-1.5"><x-icon name="user" class="h-4 w-4" />Ditulis oleh {{ $record->penulis->name }}</span>
                                    @endif
                                    <span class="flex items-center gap-1.5"><x-icon name="calendar" class="h-4 w-4" />Diperbarui {{ $record->updated_at->translatedFormat('d F Y') }}</span>
                                </p>
                            @endif
                        </div>
                    </article>
                @endif

                @if ($section->partial && $section->partial !== 'jurusan')
                    @include('frontend.sections.' . $section->partial, $related)
                @endif
            </div>

            <div class="lg:col-span-4">
                @include('frontend.partials.sidebar')
            </div>
        </div>
    </section>
@endsection
