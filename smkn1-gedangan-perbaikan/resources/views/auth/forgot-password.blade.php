<x-guest-layout>
    <x-slot:title>Lupa Kata Sandi</x-slot:title>
    <x-slot:heading>Lupa kata sandi?</x-slot:heading>
    <x-slot:subheading>Masukkan email akun Anda, kami akan mengirimkan tautan untuk membuat kata sandi baru.</x-slot:subheading>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <x-primary-button class="w-full !py-3">Kirim tautan reset</x-primary-button>
        <p class="text-center text-sm"><a href="{{ route('login') }}" class="font-semibold text-brand-700">Kembali ke halaman masuk</a></p>
    </form>
</x-guest-layout>
