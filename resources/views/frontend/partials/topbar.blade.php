<div class="hidden overflow-hidden bg-brand-950 text-[0.74rem] text-brand-100/80 transition-all duration-300 md:block"
     :class="scrolled ? 'max-h-0' : 'max-h-12'">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 sm:px-6 lg:px-8">
        <div class="flex items-center gap-5">
            <span class="inline-flex items-center gap-1.5"><x-icon name="map-pin" class="h-3.5 w-3.5 text-gold-400" />{{ config('school.address') }}</span>
            @if (config('school.phone'))
                <span class="inline-flex items-center gap-1.5"><x-icon name="phone" class="h-3.5 w-3.5 text-gold-400" />{{ config('school.phone') }}</span>
            @endif
            @if (config('school.email'))
                <a href="mailto:{{ config('school.email') }}" class="inline-flex items-center gap-1.5 hover:text-white"><x-icon name="mail" class="h-3.5 w-3.5 text-gold-400" />{{ config('school.email') }}</a>
            @endif
        </div>
        @include('frontend.partials.social', ['class' => 'h-3.5 w-3.5', 'linkClass' => 'hover:text-gold-300'])
    </div>
</div>
