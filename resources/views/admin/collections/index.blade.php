@extends('admin.layouts.app')
@section('title', $collection->label)
@section('eyebrow', $collection->group)

@php
    $image = $collection->imageField();
    $columns = $collection->textFields();
    $parent = $collection->parent ? \App\Cms\Registry::sections()[$collection->parent] ?? null : null;
@endphp

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            @if ($parent)
                <a href="{{ route('admin.sections.show', $parent->key) }}" class="btn-outline btn-sm"><x-icon name="arrow-left" class="h-4 w-4" />{{ $parent->label }}</a>
            @endif
            @if ($columns)
                <form method="GET" class="relative">
                    <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari {{ strtolower($columns[0]->label) }}..." class="form-input w-64 rounded-full py-2 pl-9">
                </form>
            @endif
        </div>
        <div class="flex gap-2">
            @if ($collection->publicRoute)
                <a href="{{ route($collection->publicRoute) }}" target="_blank" rel="noopener" class="btn-outline btn-sm"><x-icon name="external" class="h-4 w-4" />Lihat di website</a>
            @endif
            <a href="{{ route('admin.collections.create', $collection->key) }}" class="btn-primary btn-sm"><x-icon name="plus" class="h-4 w-4" />Tambah {{ $collection->singular }}</a>
        </div>
    </div>

    @if ($items->isEmpty())
        <div class="card mt-6 p-12 text-center">
            <p class="font-display text-xl font-semibold">Belum ada data</p>
            <p class="mt-1 text-sm text-slate-500">{{ $search ? 'Tidak ada hasil untuk pencarian ini.' : 'Tambahkan data pertama dengan tombol di atas.' }}</p>
        </div>
    @elseif ($collection->layout === 'cards')
        <div class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-4">
            @foreach ($items as $item)
                <div class="card group overflow-hidden">
                    <x-media :path="$item->{$image?->name ?? 'photo'}" alt="" class="aspect-[4/3] w-full {{ count($columns) && in_array('jabatan', array_map(fn ($c) => $c->name, $columns)) ? 'object-top' : '' }}" />
                    <div class="flex items-start justify-between gap-2 p-4">
                        <div class="min-w-0">
                            @foreach ($columns as $column)
                                <p class="{{ $loop->first ? 'font-semibold text-brand-950' : 'text-xs text-slate-500' }} truncate">{{ $item->{$column->name} }}</p>
                            @endforeach
                            @if (! $columns)
                                <p class="text-xs text-slate-500">{{ $item->created_at?->translatedFormat('d M Y') }}</p>
                            @endif
                        </div>
                        @include('admin.collections.actions')
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card mt-6 overflow-x-auto">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th class="w-12">#</th>
                        @foreach ($columns as $column)<th>{{ $column->label }}</th>@endforeach
                        <th class="w-28 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-slate-400">{{ $items->firstItem() + $loop->index }}</td>
                            @foreach ($columns as $column)
                                <td class="{{ $loop->first ? 'font-semibold text-brand-950' : '' }}">
                                    @if ($column->type === 'url')
                                        <a href="{{ $item->{$column->name} }}" target="_blank" rel="noopener noreferrer" class="text-brand-700 hover:underline">{{ \Illuminate\Support\Str::limit($item->{$column->name}, 45) }}</a>
                                    @else
                                        {{ $item->{$column->name} }}
                                    @endif
                                </td>
                            @endforeach
                            <td class="text-right">@include('admin.collections.actions')</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-6">{{ $items->links() }}</div>
@endsection
