<x-guest-layout>
    <x-slot:title>Masuk</x-slot:title>
    <x-slot:heading>Selamat datang kembali</x-slot:heading>
    <x-slot:subheading>Masuk untuk mengelola website atau mengirim masukan.</x-slot:subheading>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Kata sandi" class="!mb-0" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-brand-700 hover:text-brand-900" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" class="mt-1.5" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-brand-700 focus:ring-brand-500">
            Ingat saya
        </label>

        @include('partials.recaptcha')

        <x-primary-button class="w-full !py-3">Masuk</x-primary-button>

        <p class="text-center text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-brand-700 hover:text-brand-900">Daftar di sini</a></p>
    </form>
</x-guest-layout>
