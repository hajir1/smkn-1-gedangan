<section class="space-y-6">
    <header>
        <h2 class="font-display text-xl font-semibold text-brand-950">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-600">
           @if (Auth::user()->id === 1)
            akun ini merupakan akun utama Website ini , tidak bisa dihapus

           @endif
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Hapus Akun</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-display text-xl font-semibold text-brand-950">
                Yakin ingin menghapus akun Anda?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Masukkan kata sandi untuk mengonfirmasi penghapusan akun secara permanen.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Kata sandi" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Kata sandi"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
