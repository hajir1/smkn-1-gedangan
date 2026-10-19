@extends('admin.layouts.app')
@section('title', 'Ubah ' . $section->label)
@section('eyebrow', $section->group)

@section('content')
    <form action="{{ route('admin.sections.update', $section->key) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
        @csrf
        @method('PUT')
        @include('admin.partials.form-errors')
        <div class="card space-y-7 p-6 sm:p-8">
            @foreach ($section->fields as $field)
                @include('admin.partials.field', ['field' => $field, 'record' => $record])
            @endforeach
        </div>
        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.sections.show', $section->key) }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary"><x-icon name="check" class="h-4 w-4" />Simpan Perubahan</button>
        </div>
    </form>
@endsection
