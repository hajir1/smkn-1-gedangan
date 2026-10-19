<x-guest-layout>
    <x-slot:title>Konfirmasi Kata Sandi</x-slot:title>
    <x-slot:heading>Konfirmasi kata sandi</x-slot:heading>
    <x-slot:subheading>Ini area aman. Masukkan kata sandi Anda untuk melanjutkan.</x-slot:subheading>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="password" value="Kata sandi" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>
        <x-primary-button class="w-full !py-3">Konfirmasi</x-primary-button>
    </form>
</x-guest-layout>
