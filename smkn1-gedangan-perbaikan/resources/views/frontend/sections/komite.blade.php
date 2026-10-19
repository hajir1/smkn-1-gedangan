@if ($ketua)
    <div class="mt-12 card flex flex-col items-center gap-6 overflow-hidden p-6 sm:flex-row" data-aos="fade-up">
        <x-media :path="$ketua->photo" :alt="$ketua->nama" class="h-40 w-32 shrink-0 rounded-xl object-top" icon="user" />
        <div class="text-center sm:text-left">
            <p class="eyebrow">Ketua Komite</p>
            <p class="mt-2 font-display text-2xl font-semibold text-brand-950">{{ $ketua->nama }}</p>
            <p class="text-sm capitalize text-slate-500">{{ $ketua->jabatan }}</p>
        </div>
    </div>
@endif
@if ($people->isNotEmpty())
    <div class="mt-10">
        <h2 class="font-display text-2xl font-semibold">Anggota Komite</h2>
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3">
            @foreach ($people as $person)
                <figure class="card overflow-hidden" data-aos="fade-up">
                    <x-media :path="$person->photo" :alt="$person->nama" class="aspect-[4/5] w-full object-top" icon="user" />
                    <figcaption class="border-t-2 border-gold-400 p-3 text-center">
                        <p class="text-sm font-semibold capitalize text-brand-950">{{ $person->nama }}</p>
                        <p class="text-xs capitalize text-slate-500">{{ $person->jabatan }}</p>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
@endif
