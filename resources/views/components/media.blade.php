@props(['path' => null, 'alt' => '', 'icon' => 'photo'])
@php($url = \App\Support\Media::url($path))
@if ($url)
    <img src="{{ $url }}" alt="{{ $alt }}" loading="lazy" decoding="async" {{ $attributes->merge(['class' => 'object-cover']) }}>
@else
    <div {{ $attributes->merge(['class' => 'media-placeholder']) }} role="img" aria-label="{{ $alt ?: 'Belum ada gambar' }}">
        <x-icon :name="$icon" class="h-10 w-10" />
    </div>
@endif
