<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') · Admin {{ config('school.short_name') }}</title>
    <link rel="icon" href="{{ asset('img/static_icon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.flash-meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-slate-50" x-data="{ nav: false }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <div x-show="nav" x-cloak x-transition.opacity class="fixed inset-0 z-30 bg-brand-950/60 lg:hidden" x-on:click="nav = false"></div>
        <aside class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col bg-brand-950 transition-transform duration-300 lg:translate-x-0"
               :class="nav && '!translate-x-0'">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
                <span class="grid h-10 w-10 place-content-center rounded-full bg-white p-1"><x-application-logo class="h-8 w-8" /></span>
                <span class="leading-tight">
                    <span class="block font-display text-base font-semibold text-white">{{ config('school.short_name') }}</span>
                    <span class="block text-[0.65rem] font-semibold uppercase tracking-[0.22em] text-gold-300">Panel Admin</span>
                </span>
            </a>
            <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5 [scrollbar-width:thin]" aria-label="Menu admin">
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="admin-nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}"><x-icon name="chart" class="h-4 w-4" />Ringkasan</a>
                    <a href="{{ route('admin.articles.index') }}" class="admin-nav-link {{ request()->routeIs('admin.articles.*') ? 'is-active' : '' }}"><x-icon name="document" class="h-4 w-4" />Berita & Artikel</a>
                </div>
                @foreach (\App\Cms\Registry::menu() as $group => $items)
                    <div x-data="{ open: {{ collect($items)->contains('active', true) ? 'true' : 'false' }} || {{ $loop->first ? 'true' : 'false' }} }">
                        <button type="button" x-on:click="open = !open" class="flex w-full items-center justify-between px-3 text-[0.66rem] font-bold uppercase tracking-[0.2em] text-brand-300/70 hover:text-brand-100">
                            {{ $group }}
                            <x-icon name="chevron-down" class="h-3.5 w-3.5 transition" ::class="open && 'rotate-180'" />
                        </button>
                        <div x-show="open" x-transition class="mt-2 space-y-0.5">
                            @foreach ($items as $item)
                                <a href="{{ $item['url'] }}" class="admin-nav-link {{ $item['active'] ? 'is-active' : '' }}">{{ $item['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>
            <div class="border-t border-white/10 p-3">
                <a href="{{ route('welcome') }}" target="_blank" rel="noopener" class="admin-nav-link"><x-icon name="globe" class="h-4 w-4" />Lihat Website</a>
            </div>
        </aside>

        {{-- Konten --}}
        <div class="flex min-w-0 flex-1 flex-col lg:pl-72">
            <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur">
                <div class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button type="button" class="grid h-10 w-10 place-content-center rounded-lg ring-1 ring-slate-200 lg:hidden" x-on:click="nav = true" aria-label="Buka menu">
                            <x-icon name="menu" />
                        </button>
                        <div>
                            <p class="text-[0.68rem] font-semibold uppercase tracking-[0.18em] text-gold-600">@yield('eyebrow', 'Dashboard')</p>
                            <h1 class="font-display text-xl font-semibold leading-tight text-brand-950">@yield('title', 'Dashboard')</h1>
                        </div>
                    </div>
                    <div class="relative" x-data="{ menu: false }" x-on:click.outside="menu = false">
                        <button type="button" class="flex items-center gap-3 rounded-full py-1 pl-1 pr-3 ring-1 ring-slate-200 hover:bg-slate-50" x-on:click="menu = !menu">
                            <span class="grid h-8 w-8 place-content-center rounded-full bg-brand-800 text-sm font-bold uppercase text-gold-300">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                            <span class="hidden text-sm font-semibold text-brand-950 sm:block">{{ auth()->user()->name }}</span>
                            <x-icon name="chevron-down" class="h-4 w-4 text-slate-400" />
                        </button>
                        <div x-show="menu" x-cloak x-transition.origin.top.right class="absolute right-0 mt-2 w-56 overflow-hidden rounded-xl bg-white p-1.5 shadow-xl ring-1 ring-slate-100">
                            <div class="px-3 py-2">
                                <p class="text-sm font-semibold text-brand-950">{{ auth()->user()->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"><x-icon name="cog" class="h-4 w-4" />Pengaturan Akun</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-rose-600 hover:bg-rose-50"><x-icon name="logout" class="h-4 w-4" />Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
                @yield('content')
            </main>

            <footer class="px-4 py-6 text-xs text-slate-400 sm:px-6 lg:px-8">&copy; {{ now()->year }} {{ config('school.name') }}</footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
