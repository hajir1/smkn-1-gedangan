{{-- $title, $eyebrow, $lead, $crumbs = [[label, url?], ...] --}}
<section class="page-hero">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="mb-6 flex flex-wrap items-center gap-1.5 text-xs font-medium text-brand-200/80" aria-label="Breadcrumb">
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-1 hover:text-white"><x-icon name="home" class="h-3.5 w-3.5" />Beranda</a>
            @foreach ($crumbs ?? [] as $crumb)
                <x-icon name="chevron-right" class="h-3 w-3 text-brand-300/60" />
                @if (! empty($crumb[1]))
                    <a href="{{ $crumb[1] }}" class="hover:text-white">{{ $crumb[0] }}</a>
                @else
                    <span class="{{ $loop->last ? 'text-gold-300' : '' }}">{{ $crumb[0] }}</span>
                @endif
            @endforeach
        </nav>
        @if (! empty($eyebrow))
            <p class="eyebrow !text-gold-300 before:!bg-gold-300" data-aos="fade-up">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-3 max-w-4xl font-display text-4xl font-semibold leading-[1.1] tracking-tight !text-white md:text-5xl" data-aos="fade-up" data-aos-delay="50">{{ $title }}</h1>
        @if (! empty($lead))
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-brand-100/80" data-aos="fade-up" data-aos-delay="100">{{ $lead }}</p>
        @endif
    </div>
    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-gold-400/60 to-transparent"></div>
</section>
