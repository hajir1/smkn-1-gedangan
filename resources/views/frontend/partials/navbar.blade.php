@php($menu = \App\Support\Navigation::main())
<header x-data="{ scrolled: false, open: false }"
        x-init="scrolled = window.scrollY > 24"
        x-on:scroll.window="scrolled = window.scrollY > 24"
        x-on:keydown.escape.window="open = false"
        class="fixed inset-x-0 top-0 z-50">

    @include('frontend.partials.topbar')

    <nav :class="scrolled ? 'bg-white/95 shadow-[0_10px_30px_-18px_rgba(13,26,49,0.45)] backdrop-blur text-brand-950' : 'bg-transparent text-white'"
         class="transition-all duration-300" aria-label="Menu utama">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8"
             :class="scrolled ? 'py-2.5' : 'py-4'">
            <a href="{{ route('welcome') }}" class="group flex items-center gap-3">
                <span class="grid h-11 w-11 place-content-center rounded-full bg-white p-1 shadow-sm ring-1 ring-black/5">
                    <x-application-logo class="h-9 w-9" />
                </span>
                <span class="leading-tight">
                    <span class="block font-display text-[1.05rem] font-semibold tracking-tight">SMK Negeri 1 Gedangan</span>
                    <span class="block text-[0.68rem] font-semibold uppercase tracking-[0.22em]" :class="scrolled ? 'text-gold-600' : 'text-gold-300'">{{ config('school.city') }}</span>
                </span>
            </a>

            {{-- Desktop --}}
            <ul class="hidden items-center gap-0.5 lg:flex">
                <li>
                    <a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'text-gold-500' : 'hover:text-gold-500' }}">Beranda</a>
                </li>
                @foreach ($menu as $group)
                    @php($active = request()->is($group['prefix'] . '*') || collect($group['items'])->contains(fn ($i) => request()->routeIs($i['route'])))
                    <li class="relative" x-data="{ drop: false }" x-on:mouseenter="drop = true" x-on:mouseleave="drop = false">
                        <button type="button" class="nav-link {{ $active ? 'text-gold-500' : 'hover:text-gold-500' }}"
                                x-on:click="drop = !drop" :aria-expanded="drop">
                            {{ $group['label'] }}
                            <x-icon name="chevron-down" class="h-3.5 w-3.5 transition" ::class="drop && 'rotate-180'" />
                        </button>
                        <div x-show="drop" x-cloak x-transition.origin.top
                             class="absolute left-1/2 top-full w-72 -translate-x-1/2 pt-3">
                            <div class="overflow-hidden rounded-2xl bg-white p-2 text-brand-950 shadow-[0_24px_60px_-20px_rgba(13,26,49,0.45)] ring-1 ring-brand-950/5">
                                @foreach ($group['items'] as $item)
                                    <a href="{{ route($item['route']) }}" @if(!empty($item['external'])) target="_blank" rel="noopener" @endif
                                       class="flex items-center justify-between gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition hover:bg-brand-50 {{ request()->routeIs($item['route']) ? 'bg-brand-50 text-brand-800' : 'text-slate-700' }}">
                                        {{ $item['label'] }}
                                        <x-icon :name="!empty($item['external']) ? 'external' : 'chevron-right'" class="h-4 w-4 text-slate-300" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="hidden items-center gap-2 lg:flex">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="btn-gold btn-sm">Dashboard</a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button class="btn-sm btn" :class="scrolled ? 'btn-outline' : 'btn-ghost-light'">Keluar</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-gold btn-sm">Masuk</a>
                @endauth
            </div>

            <button type="button" class="grid h-10 w-10 place-content-center rounded-full ring-1 lg:hidden"
                    :class="scrolled ? 'ring-slate-200' : 'ring-white/30'" x-on:click="open = true" aria-label="Buka menu">
                <x-icon name="menu" class="h-5 w-5" />
            </button>
        </div>
    </nav>

    {{-- Mobile drawer --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="open" x-transition.opacity class="absolute inset-0 bg-brand-950/60 backdrop-blur-sm" x-on:click="open = false"></div>
        <div x-show="open" x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-x-full"
             x-transition:leave="transition duration-200 ease-in" x-transition:leave-end="translate-x-full"
             class="absolute inset-y-0 right-0 flex w-[86%] max-w-sm flex-col overflow-y-auto bg-white text-brand-950 shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <span class="font-display text-lg font-semibold">Menu</span>
                <button type="button" class="grid h-9 w-9 place-content-center rounded-full bg-slate-100" x-on:click="open = false" aria-label="Tutup menu">
                    <x-icon name="x" class="h-5 w-5" />
                </button>
            </div>
            <div class="flex-1 space-y-1 px-3 py-4">
                <a href="{{ route('welcome') }}" class="block rounded-xl px-3 py-2.5 font-semibold hover:bg-brand-50">Beranda</a>
                @foreach ($menu as $group)
                    <div x-data="{ sub: {{ request()->is($group['prefix'] . '*') ? 'true' : 'false' }} }">
                        <button type="button" class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 font-semibold hover:bg-brand-50" x-on:click="sub = !sub">
                            {{ $group['label'] }}
                            <x-icon name="chevron-down" class="h-4 w-4 transition" ::class="sub && 'rotate-180'" />
                        </button>
                        <div x-show="sub" x-transition x-cloak class="ml-3 border-l-2 border-gold-200 pl-3">
                            @foreach ($group['items'] as $item)
                                <a href="{{ route($item['route']) }}" @if(!empty($item['external'])) target="_blank" rel="noopener" @endif
                                   class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs($item['route']) ? 'font-semibold text-brand-800' : 'text-slate-600' }}">{{ $item['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-slate-100 p-4">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="btn-primary w-full">Buka Dashboard</a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn-outline w-full">Keluar</button></form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full">Masuk</a>
                @endauth
            </div>
        </div>
    </div>
</header>
