@if ($photos->isNotEmpty())
    <div class="mt-12" x-data="{ open: null }">
        <h2 class="font-display text-2xl font-semibold">Dokumentasi</h2>
        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
            @foreach ($photos as $photo)
                @php($url = \App\Support\Media::url($photo->photo))
                <button type="button" class="group overflow-hidden rounded-xl" @if($url) x-on:click="open = @js($url)" @endif data-aos="zoom-in">
                    <x-media :path="$photo->photo" :alt="'Dokumentasi ' . $section->label" class="aspect-square w-full transition duration-500 group-hover:scale-105" />
                </button>
            @endforeach
        </div>
        <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-[60] grid place-content-center bg-brand-950/90 p-4" x-on:click="open = null" x-on:keydown.escape.window="open = null">
            <img :src="open" alt="" class="max-h-[85vh] max-w-full rounded-xl shadow-2xl">
        </div>
    </div>
@endif
