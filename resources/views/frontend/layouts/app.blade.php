<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php($pageTitle = trim($__env->yieldContent('title')))
    <title>{{ $pageTitle ? $pageTitle . ' | ' : '' }}{{ config('school.name') }}</title>
    <meta name="description" content="@yield('description', config('school.tagline'))">
    <meta property="og:title" content="{{ $pageTitle ?: config('school.name') }}">
    <meta property="og:description" content="@yield('description', config('school.tagline'))">
    <meta property="og:type" content="website">
    <meta property="og:image" content="@yield('og_image', asset('img/static_icon.png'))">
    <meta name="theme-color" content="#0d1a31">
    <link rel="icon" href="{{ asset('img/static_icon.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @include('partials.flash-meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen">
    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-brand-900">Lewati ke konten</a>

    @include('frontend.partials.navbar', ['transparent' => $transparentNav ?? false])

    <main id="konten">
        @yield('content')
    </main>

    @unless (View::hasSection('hide_contact'))
        @include('frontend.partials.contact')
    @endunless

    @include('frontend.partials.footer')

    <button type="button" x-data="{ show: false }" x-on:scroll.window="show = window.scrollY > 600" x-show="show" x-cloak x-transition.opacity
        x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-5 z-40 grid h-11 w-11 place-content-center rounded-full bg-brand-900 text-gold-300 shadow-lg ring-1 ring-white/10 transition hover:bg-brand-800"
        aria-label="Kembali ke atas">
        <x-icon name="arrow-up" class="h-5 w-5" />
    </button>

    @stack('scripts')
</body>
</html>
