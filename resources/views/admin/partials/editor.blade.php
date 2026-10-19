{{--
    Editor Quill. Nilai lama (old()) disanitasi dulu sebelum ditampilkan agar
    tidak terjadi reflected XSS saat validasi gagal.
--}}
@php($editorId = 'editor-' . $name)
@php($initial = app(\App\Services\HtmlSanitizer::class)->clean(old($name, $value)))
@once
    @push('scripts')
        @vite('resources/js/editor.js')
    @endpush
@endonce
<div id="{{ $editorId }}" data-quill="{{ $editorId }}-input" class="bg-white">{!! $initial !!}</div>
<input type="hidden" name="{{ $name }}" id="{{ $editorId }}-input" value="{{ $initial }}">
