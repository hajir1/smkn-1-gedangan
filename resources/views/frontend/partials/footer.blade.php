@php($menu = \App\Support\Navigation::main())
<footer class="relative overflow-hidden bg-brand-950 text-brand-100/80">
    <div class="pointer-events-none absolute -left-24 top-0 h-72 w-72 rounded-full bg-brand-600/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-gold-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-4 pb-10 pt-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3">
                    <span class="grid h-12 w-12 place-content-center rounded-full bg-white p-1"><x-application-logo class="h-10 w-10" /></span>
                    <div>
                        <p class="font-display text-lg font-semibold text-white">{{ config('school.name') }}</p>
                        <p class="text-xs uppercase tracking-[0.2em] text-gold-300">{{ config('school.city') }}</p>
                    </div>
                </div>
                <p class="mt-5 max-w-sm text-sm leading-relaxed">{{ config('school.tagline') }}</p>
                <div class="mt-6">
                    @include('frontend.partials.social', ['class' => 'h-5 w-5', 'linkClass' => 'grid h-10 w-10 place-content-center rounded-full bg-white/5 ring-1 ring-white/10 hover:bg-gold-400 hover:text-brand-950'])
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:col-span-8">
                @foreach (collect($menu)->whereIn('label', ['Profil', 'Program', 'Informasi']) as $group)
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-gold-300">{{ $group['label'] }}</p>
                        <ul class="mt-4 space-y-2.5 text-sm">
                            @foreach ($group['items'] as $item)
                                <li><a href="{{ route($item['route']) }}" class="transition hover:text-white" @if(!empty($item['external'])) target="_blank" rel="noopener" @endif>{{ $item['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-14 flex flex-col gap-4 border-t border-white/10 pt-6 text-xs sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} {{ config('school.name') }}. Hak cipta dilindungi.</p>
            <div class="flex items-center gap-5">
                @auth
                    <form action="{{ route('logout') }}" method="POST">@csrf<button class="hover:text-white">Keluar</button></form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-white">Masuk</a>
                @endauth
                <a href="https://usammuhazir.vercel.app/" target="_blank" rel="noopener" class="hover:text-white">Tentang pengembang</a>
            </div>
        </div>
    </div>
</footer>
