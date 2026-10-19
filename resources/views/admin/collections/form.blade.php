@extends('admin.layouts.app')
@section('title', ($record->exists ? 'Ubah ' : 'Tambah ') . $collection->singular)
@section('eyebrow', $collection->label)

@section('content')
    <form action="{{ $record->exists ? route('admin.collections.update', [$collection->key, $record->id]) : route('admin.collections.store', $collection->key) }}"
          method="POST" enctype="multipart/form-data" class="max-w-3xl">
        @csrf
        @if ($record->exists) @method('PUT') @endif
        @include('admin.partials.form-errors')
        <div class="card space-y-6 p-6 sm:p-8">
            @foreach ($collection->fields as $field)
                @include('admin.partials.field', ['field' => $field, 'record' => $record])
            @endforeach
        </div>
        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.collections.index', $collection->key) }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary"><x-icon name="check" class="h-4 w-4" />{{ $record->exists ? 'Simpan Perubahan' : 'Simpan' }}</button>
        </div>
    </form>
@endsection
