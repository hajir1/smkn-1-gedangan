<x-guest-layout>
    <x-slot:title>Atur Ulang Kata Sandi</x-slot:title>
    <x-slot:heading>Buat kata sandi baru</x-slot:heading>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <div>
            <x-input-label for="password" value="Kata sandi baru" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>
        <div>
            <x-input-label for="password_confirmation" value="Ulangi kata sandi" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>
        <x-primary-button class="w-full !py-3">Simpan kata sandi</x-primary-button>
    </form>
</x-guest-layout>
