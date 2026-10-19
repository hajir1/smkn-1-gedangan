@php($social = $social ?? \App\Support\SiteCache::remember('social-links', fn () => \App\Models\Link::query()->first()))
@if ($social)
    <div class="flex items-center gap-3">
        @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'tiktok' => 'TikTok', 'website' => 'Website'] as $field => $label)
            @if (filled($social->{$field}))
                <a href="{{ $social->{$field} }}" target="_blank" rel="noopener noreferrer" class="{{ $linkClass ?? '' }} transition" aria-label="{{ $label }}">
                    <x-icon :name="$field === 'website' ? 'globe' : $field" :class="$class ?? 'h-4 w-4'" />
                </a>
            @endif
        @endforeach
    </div>
@endif
