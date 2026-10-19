@if (($people ?? collect())->isNotEmpty())
    <div class="mt-12">
        <h2 class="font-display text-2xl font-semibold">{{ $section->key === 'osis' ? 'Pengurus OSIS' : 'Pimpinan & Wakil Kepala Sekolah' }}</h2>
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3">
            @foreach ($people as $person)
                <figure class="card overflow-hidden" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 60 }}">
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
