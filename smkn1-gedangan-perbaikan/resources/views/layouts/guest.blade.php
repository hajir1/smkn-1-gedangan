<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <title>{{ $title ?? 'Masuk' }} · {{ config('school.name') }}</title>
    <link rel="icon" href="{{ asset('img/static_icon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.flash-meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="relative hidden overflow-hidden bg-brand-950 lg:block">
            <img src="{{ asset('img/welcome/static_baner1.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-950/80 to-brand-800/60"></div>
            <div class="relative flex h-full flex-col justify-between p-12 text-white">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="grid h-12 w-12 place-content-center rounded-full bg-white p-1"><x-application-logo class="h-10 w-10" /></span>
                    <span>
                        <span class="block font-display text-lg font-semibold">{{ config('school.name') }}</span>
                        <span class="block text-xs uppercase tracking-[0.22em] text-gold-300">{{ config('school.city') }}</span>
                    </span>
                </a>
                <div class="max-w-md">
                    <x-icon name="quote" class="h-10 w-10 text-gold-400" />
                    <p class="mt-4 font-display text-3xl font-semibold leading-snug !text-white">Kompeten, mandiri, dan berakhlak mulia.</p>
                    <p class="mt-4 text-sm leading-relaxed text-brand-100/80">{{ config('school.tagline') }}</p>
                </div>
                <p class="text-xs text-brand-200/70">&copy; {{ now()->year }} {{ config('school.name') }}</p>
            </div>
        </div>

        <div class="flex flex-col justify-center px-6 py-12 sm:px-12">
            <div class="mx-auto w-full max-w-md">
                <a href="{{ url('/') }}" class="mb-10 flex items-center gap-3 lg:hidden">
                    <x-application-logo class="h-11 w-11" />
                    <span class="font-display text-lg font-semibold text-brand-950">{{ config('school.name') }}</span>
                </a>
                @isset($heading)
                    <h1 class="font-display text-3xl font-semibold text-brand-950">{{ $heading }}</h1>
                @endisset
                @isset($subheading)
                    <p class="mt-2 text-sm text-slate-500">{{ $subheading }}</p>
                @endisset
                <div class="mt-8">
                    {{ $slot }}
                </div>
                <a href="{{ url('/') }}" class="mt-10 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-brand-800"><x-icon name="arrow-left" class="h-4 w-4" />Kembali ke website</a>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
