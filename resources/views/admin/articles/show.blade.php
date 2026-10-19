@extends('admin.layouts.app')
@section('title', 'Pratinjau Artikel')
@section('eyebrow', 'Berita & Artikel')

@section('content')
    <div class="mb-6 flex flex-wrap justify-between gap-3">
        <a href="{{ route('admin.articles.index') }}" class="btn-outline btn-sm"><x-icon name="arrow-left" class="h-4 w-4" />Kembali</a>
        <div class="flex gap-2">
            <a href="{{ route('readArticle', $article->slug) }}" target="_blank" rel="noopener" class="btn-outline btn-sm"><x-icon name="external" class="h-4 w-4" />Lihat di website</a>
            <a href="{{ route('admin.articles.edit', $article) }}" class="btn-primary btn-sm"><x-icon name="pencil" class="h-4 w-4" />Ubah</a>
        </div>
    </div>
    <article class="card mx-auto max-w-4xl overflow-hidden">
        <x-media :path="$article->image" :alt="$article->title" class="max-h-[28rem] w-full" />
        <div class="p-6 sm:p-10">
            <div class="flex flex-wrap gap-2">@foreach ($article->kategoris as $k)<span class="chip capitalize">{{ $k->nama }}</span>@endforeach</div>
            <h2 class="mt-3 font-display text-3xl font-semibold">{{ $article->title }}</h2>
            <p class="mt-2 text-sm text-slate-500">{{ $article->writer?->name ?? 'Admin' }} · {{ $article->created_at->translatedFormat('d F Y') }} · {{ number_format($article->view) }} kali dibaca</p>
            <div class="richtext mt-8">{!! $article->text_content !!}</div>
        </div>
    </article>
@endsection
