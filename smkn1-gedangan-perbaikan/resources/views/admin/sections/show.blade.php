@extends('admin.layouts.app')
@section('title', $section->label)
@section('eyebrow', $section->group)

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="max-w-2xl text-sm text-slate-500">{{ $section->description ?? 'Pratinjau konten yang tampil di website.' }}</p>
        <div class="flex flex-wrap gap-2">
            @if ($section->publicRoute)
                <a href="{{ route($section->publicRoute) }}" target="_blank" rel="noopener" class="btn-outline btn-sm"><x-icon name="external" class="h-4 w-4" />Lihat di website</a>
            @endif
            <a href="{{ route('admin.sections.edit', $section->key) }}" class="btn-primary btn-sm"><x-icon name="pencil" class="h-4 w-4" />Ubah {{ $section->label }}</a>
        </div>
    </div>

    <div class="card mt-6 overflow-hidden">
        @if (! $record->exists)
            <div class="p-10 text-center">
                <p class="font-display text-xl font-semibold">Konten belum diisi</p>
                <p class="mt-1 text-sm text-slate-500">Klik tombol “Ubah” untuk mengisi konten halaman ini.</p>
            </div>
        @else
            <dl class="divide-y divide-slate-100">
                @foreach ($section->fields as $field)
                    <div class="grid gap-2 px-6 py-5 md:grid-cols-[14rem_1fr]">
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $field->label }}</dt>
                        <dd class="min-w-0">
                            @if ($field->isImage())
                                <x-media :path="$record->{$field->name}" :alt="$field->label" class="h-48 max-w-md rounded-xl object-contain bg-slate-50 ring-1 ring-slate-100" />
                            @elseif ($field->type === 'richtext')
                                <div class="richtext max-h-96 overflow-y-auto text-sm">{!! $record->{$field->name} !!}</div>
                            @elseif ($field->type === 'url')
                                <a href="{{ $record->{$field->name} }}" target="_blank" rel="noopener noreferrer" class="break-all text-sm text-brand-700 hover:underline">{{ $record->{$field->name} }}</a>
                            @else
                                <p class="text-sm font-medium text-brand-950">{{ $record->{$field->name} }}</p>
                            @endif
                        </dd>
                    </div>
                @endforeach
                <div class="px-6 py-4 text-xs text-slate-400">Terakhir diperbarui {{ $record->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}</div>
            </dl>
        @endif
    </div>

    @if ($children->isNotEmpty())
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @foreach ($children as $child)
                @php($isCollection = $child instanceof \App\Cms\Collection)
                <a href="{{ $isCollection ? route('admin.collections.index', $child->key) : route('admin.sections.show', $child->key) }}"
                   class="card card-hover flex items-center gap-4 p-5">
                    <span class="grid h-11 w-11 place-content-center rounded-xl bg-gold-100 text-gold-700"><x-icon :name="$isCollection ? 'users' : 'user'" /></span>
                    <span class="flex-1">
                        <span class="block font-semibold text-brand-950">{{ $child->label }}</span>
                        <span class="block text-xs text-slate-500">{{ $isCollection ? $child->model::query()->count() . ' data' : 'Kelola data' }}</span>
                    </span>
                    <x-icon name="chevron-right" class="h-4 w-4 text-slate-300" />
                </a>
            @endforeach
        </div>
    @endif
@endsection
