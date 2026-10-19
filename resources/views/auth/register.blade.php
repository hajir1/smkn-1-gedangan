<x-guest-layout>
    <x-slot:title>Daftar</x-slot:title>
    <x-slot:heading>Buat akun</x-slot:heading>
    <x-slot:subheading>Akun pengunjung digunakan untuk mengirim masukan kepada sekolah.</x-slot:subheading>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="name" value="Nama lengkap" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" maxlength="255" />
            <x-input-error :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="password" value="Kata sandi" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" minlength="8" />
            </div>
            <div>
                <x-input-label for="password_confirmation" value="Ulangi kata sandi" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
        </div>
        <p class="form-help !mt-2">Minimal 8 karakter, mengandung huruf dan angka.</p>
        <x-input-error :messages="$errors->get('password')" />

        @include('partials.recaptcha')

        <x-primary-button class="w-full !py-3">Daftar</x-primary-button>
        <p class="text-center text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-brand-700 hover:text-brand-900">Masuk</a></p>
    </form>
</x-guest-layout>
