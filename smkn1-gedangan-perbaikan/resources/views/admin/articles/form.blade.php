@extends('admin.layouts.app')
@section('title', $article->exists ? 'Ubah Artikel' : 'Tulis Artikel')
@section('eyebrow', 'Berita & Artikel')

@section('content')
    <form action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($article->exists) @method('PUT') @endif
        @include('admin.partials.form-errors')

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="card space-y-6 p-6 sm:p-8 xl:col-span-2">
                <div>
                    <label for="title" class="form-label">Judul</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}" class="form-input text-base font-semibold" required minlength="6" maxlength="150">
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Konten</label>
                    @include('admin.partials.editor', ['name' => 'text_content', 'value' => $article->text_content])
                    @error('text_content') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6">
                    <p class="form-label">Kategori</p>
                    @php($selected = collect(old('kategori_id', $article->kategoris?->pluck('id')->all() ?? []))->map(fn ($id) => (int) $id)->all())
                    <div class="mt-2 space-y-2">
                        @foreach ($kategoris as $kategori)
                            <label class="flex items-center gap-3 rounded-lg px-3 py-2 ring-1 ring-slate-200 has-[:checked]:bg-brand-50 has-[:checked]:ring-brand-300">
                                <input type="checkbox" name="kategori_id[]" value="{{ $kategori->id }}" class="rounded border-slate-300 text-brand-700 focus:ring-brand-500" @checked(in_array($kategori->id, $selected))>
                                <span class="text-sm font-medium capitalize text-slate-700">{{ $kategori->nama }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('kategori_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="card p-6">
                    @include('admin.partials.field', ['field' => \App\Cms\Field::image('image', 'Gambar Utama', 'articles_images'), 'record' => $article])
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.articles.index') }}" class="btn-outline flex-1">Batal</a>
                    <button type="submit" class="btn-primary flex-1"><x-icon name="check" class="h-4 w-4" />{{ $article->exists ? 'Simpan' : 'Publikasikan' }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
