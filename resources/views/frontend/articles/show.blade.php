@extends('frontend.layouts.app')
@section('title', $article->title)
@section('description', $article->excerpt(30))
@section('og_image', \App\Support\Media::url($article->image) ?? asset('img/static_icon.png'))

@section('content')
    @include('frontend.partials.page-hero', [
        'title' => $article->title,
        'eyebrow' => $article->kategoris->pluck('nama')->map(fn ($n) => ucfirst($n))->implode(' · ') ?: 'Berita',
        'crumbs' => [['Berita & Artikel', route('artikel')], [\Illuminate\Support\Str::limit($article->title, 40)]],
    ])

    <section class="py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
            <article class="min-w-0 lg:col-span-8">
                <div class="card overflow-hidden" data-aos="fade-up">
                    <x-media :path="$article->image" :alt="$article->title" class="max-h-[34rem] w-full" />
                    <div class="p-6 sm:p-10">
                        <div class="mb-8 flex flex-wrap items-center gap-x-5 gap-y-2 border-b border-slate-100 pb-6 text-sm text-slate-500">
                            <span class="flex items-center gap-2"><x-icon name="user" class="h-4 w-4 text-gold-500" />{{ $article->writer?->name ?? 'Admin' }}</span>
                            <span class="flex items-center gap-2"><x-icon name="calendar" class="h-4 w-4 text-gold-500" />{{ $article->created_at->translatedFormat('l, d F Y') }}</span>
                            <span class="flex items-center gap-2"><x-icon name="eye" class="h-4 w-4 text-gold-500" />{{ number_format($article->view) }} kali dibaca</span>
                        </div>
                        <div class="richtext">{!! $article->text_content !!}</div>
                    </div>
                </div>

                @if ($related->isNotEmpty())
                    <div class="mt-12">
                        <h2 class="font-display text-2xl font-semibold">Baca juga</h2>
                        <div class="mt-6 grid gap-5 sm:grid-cols-3">
                            @foreach ($related as $item)
                                <a href="{{ route('readArticle', $item->slug) }}" class="card card-hover group overflow-hidden">
                                    <x-media :path="$item->image" :alt="$item->title" class="aspect-[16/10] w-full" />
                                    <div class="p-4">
                                        <p class="line-clamp-2 text-sm font-semibold text-brand-950 group-hover:text-brand-700">{{ $item->title }}</p>
                                        <p class="mt-1 text-xs text-slate-400">{{ $item->created_at->translatedFormat('d M Y') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>
            <div class="lg:col-span-4">@include('frontend.partials.sidebar')</div>
        </div>
    </section>
@endsection
