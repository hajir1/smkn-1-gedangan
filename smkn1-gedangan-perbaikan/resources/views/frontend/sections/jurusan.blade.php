<div class="relative">
    <x-media :path="$record->photo" :alt="$record->judul" class="aspect-[16/8] w-full" icon="academic" />
    <div class="absolute inset-0 bg-gradient-to-t from-brand-950/70 to-transparent"></div>
</div>
@if ($record->nama_kaprog)
    <div class="relative mx-6 -mt-16 flex flex-col items-center gap-5 rounded-2xl bg-white p-5 shadow-xl ring-1 ring-slate-100 sm:mx-10 sm:flex-row">
        <x-media :path="$record->photo_kaprog" :alt="$record->nama_kaprog" class="h-28 w-24 shrink-0 rounded-xl object-top" icon="user" />
        <div class="text-center sm:text-left">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-600">Kepala Program Keahlian</p>
            <p class="mt-1 font-display text-xl font-semibold text-brand-950">{{ $record->nama_kaprog }}</p>
            <p class="text-sm capitalize text-slate-500">{{ $record->ket_kaprog }}</p>
        </div>
    </div>
@endif
