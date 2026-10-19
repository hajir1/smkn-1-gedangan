<x-guest-layout>
    <x-slot:title>Verifikasi Email</x-slot:title>
    <x-slot:heading>Verifikasi email Anda</x-slot:heading>
    <x-slot:subheading>Kami sudah mengirim tautan verifikasi ke email Anda. Belum menerima? Kirim ulang dengan tombol di bawah.</x-slot:subheading>

    @if (session('status') == 'verification-link-sent')
        <x-auth-session-status class="mb-6" status="Tautan verifikasi baru sudah dikirim ke email Anda." />
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-xl bg-amber-50 px-4 py-3 text-sm text-amber-800 ring-1 ring-amber-100">{{ session('error') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>Kirim ulang email verifikasi</x-primary-button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-brand-800">Keluar</button>
        </form>
    </div>
</x-guest-layout>
