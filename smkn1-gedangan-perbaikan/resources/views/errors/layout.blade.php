<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') · {{ config('school.name') }}</title>
    <link rel="icon" href="{{ asset('img/static_icon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="page-hero !flex min-h-screen items-center !pt-16">
    <div class="mx-auto max-w-xl px-6 text-center">
        <img src="{{ asset('img/static_icon.png') }}" alt="" class="mx-auto h-16 w-16 rounded-full bg-white p-1.5">
        <p class="mt-8 font-display text-8xl font-semibold text-gold-300">@yield('code')</p>
        <h1 class="mt-4 font-display text-3xl font-semibold !text-white">@yield('title')</h1>
        <p class="mt-3 text-brand-100/80">@yield('message')</p>
        <a href="{{ url('/') }}" class="btn-gold mt-8">Kembali ke Beranda</a>
    </div>
</body>
</html>
