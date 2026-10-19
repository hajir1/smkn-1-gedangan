<section id="kontak" class="relative bg-white py-20">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:px-8">
        <div class="lg:col-span-5" data-aos="fade-up">
            <p class="eyebrow">Hubungi Kami</p>
            <h2 class="section-title mt-3">Kritik, saran, atau laporan kendala website</h2>
            <p class="section-lead">Masukan Anda membantu kami melayani lebih baik. Pesan akan diterima langsung oleh admin sekolah.</p>

            <dl class="mt-8 space-y-4 text-sm">
                <div class="flex gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-content-center rounded-full bg-brand-50 text-brand-700"><x-icon name="map-pin" /></span>
                    <div><dt class="font-semibold text-brand-950">Alamat</dt><dd class="text-slate-500">{{ config('school.address') }}</dd></div>
                </div>
                @if (config('school.phone'))
                    <div class="flex gap-3">
                        <span class="grid h-10 w-10 shrink-0 place-content-center rounded-full bg-brand-50 text-brand-700"><x-icon name="phone" /></span>
                        <div><dt class="font-semibold text-brand-950">Telepon</dt><dd class="text-slate-500">{{ config('school.phone') }}</dd></div>
                    </div>
                @endif
                @if (config('school.email'))
                    <div class="flex gap-3">
                        <span class="grid h-10 w-10 shrink-0 place-content-center rounded-full bg-brand-50 text-brand-700"><x-icon name="mail" /></span>
                        <div><dt class="font-semibold text-brand-950">Email</dt><dd class="text-slate-500">{{ config('school.email') }}</dd></div>
                    </div>
                @endif
            </dl>

            <div class="mt-8 overflow-hidden rounded-2xl ring-1 ring-slate-200">
                <iframe src="{{ config('school.maps_embed') }}" title="Peta lokasi {{ config('school.name') }}" class="h-56 w-full" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            </div>
        </div>

        <div class="lg:col-span-7" data-aos="fade-up" data-aos-delay="100">
            <div class="card p-6 sm:p-8">
                @auth
                    <form action="{{ route('save_masukan') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="kontak-email" class="form-label">Email</label>
                                <input id="kontak-email" type="email" value="{{ auth()->user()->email }}" class="form-input bg-slate-50 text-slate-500" readonly>
                                <p class="form-help">Diambil dari akun Anda.</p>
                            </div>
                            <div>
                                <label for="kontak-nama" class="form-label">Nama</label>
                                <input id="kontak-nama" type="text" name="nama" value="{{ old('nama', auth()->user()->name) }}" class="form-input" required maxlength="100" autocomplete="name">
                                @error('nama') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="kontak-pesan" class="form-label">Pesan</label>
                            <textarea id="kontak-pesan" name="masukan" rows="6" class="form-input" required minlength="5" maxlength="2000" placeholder="Tuliskan pesan, saran, atau kendala yang Anda temukan...">{{ old('masukan') }}</textarea>
                            @error('masukan') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        @include('partials.recaptcha')
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <p class="text-xs text-slate-400">Dengan mengirim pesan, email Anda akan terlihat oleh admin sekolah.</p>
                            <button type="submit" class="btn-primary">Kirim Pesan <x-icon name="arrow-right" class="h-4 w-4" /></button>
                        </div>
                    </form>
                @else
                    <div class="flex flex-col items-center py-10 text-center">
                        <span class="grid h-14 w-14 place-content-center rounded-full bg-gold-100 text-gold-700"><x-icon name="mail" class="h-7 w-7" /></span>
                        <h3 class="mt-5 font-display text-2xl font-semibold">Masuk untuk mengirim pesan</h3>
                        <p class="mt-2 max-w-md text-sm text-slate-500">Untuk mencegah spam, formulir kontak hanya dapat digunakan oleh pengguna yang sudah memiliki akun terverifikasi.</p>
                        <div class="mt-6 flex flex-wrap justify-center gap-3">
                            <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
                            <a href="{{ route('register') }}" class="btn-outline">Daftar Akun</a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</section>
