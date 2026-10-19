@extends('admin.layouts.app')
@section('title', 'Ringkasan')
@section('eyebrow', 'Selamat datang, ' . auth()->user()->name)

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Pengunjung hari ini', 'value' => $stats['visitors_today'], 'icon' => 'eye', 'tone' => 'bg-brand-800 text-gold-300'],
            ['label' => 'Total pengunjung', 'value' => $stats['visitors_total'], 'icon' => 'chart', 'tone' => 'bg-brand-50 text-brand-700'],
            ['label' => 'Berita & artikel', 'value' => $stats['articles'], 'icon' => 'document', 'tone' => 'bg-gold-100 text-gold-700'],
            ['label' => 'Masukan masuk', 'value' => $stats['masukans'], 'icon' => 'inbox', 'tone' => 'bg-emerald-50 text-emerald-700'],
        ] as $card)
            <div class="card flex items-center gap-4 p-5">
                <span class="grid h-12 w-12 place-content-center rounded-xl {{ $card['tone'] }}"><x-icon :name="$card['icon']" class="h-6 w-6" /></span>
                <div>
                    <p class="font-display text-3xl font-semibold text-brand-950">{{ number_format($card['value']) }}</p>
                    <p class="text-xs font-medium text-slate-500">{{ $card['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <div class="card p-6 xl:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-display text-lg font-semibold">Kunjungan 14 hari terakhir</h2>
                    <p class="text-xs text-slate-500">1 kunjungan dihitung per perangkat per hari.</p>
                </div>
            </div>
            @php($max = max(1, $chart->max('value')))
            <div class="mt-6 flex h-56 items-end gap-2">
                @foreach ($chart as $day)
                    <div class="group flex h-full flex-1 flex-col items-center justify-end gap-2">
                        <span class="text-[0.65rem] font-semibold text-brand-700 opacity-0 transition group-hover:opacity-100">{{ $day['value'] }}</span>
                        <div class="w-full rounded-t-md bg-gradient-to-t from-brand-800 to-brand-500 transition group-hover:from-gold-500 group-hover:to-gold-300"
                             style="height: {{ max(2, round($day['value'] / $max * 100)) }}%"></div>
                        <span class="text-[0.6rem] text-slate-400 {{ $loop->index % 2 ? 'hidden sm:block' : '' }}">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-semibold">Artikel terbaru</h2>
                <a href="{{ route('admin.articles.create') }}" class="btn-primary btn-sm"><x-icon name="plus" class="h-4 w-4" />Tulis</a>
            </div>
            <ul class="mt-4 divide-y divide-slate-100">
                @forelse ($latestArticles as $article)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="line-clamp-1 text-sm font-medium text-brand-950 hover:text-brand-700">{{ $article->title }}</a>
                        <span class="shrink-0 text-xs text-slate-400">{{ number_format($article->view) }} <x-icon name="eye" class="inline h-3.5 w-3.5" /></span>
                    </li>
                @empty
                    <li class="py-6 text-center text-sm text-slate-400">Belum ada artikel.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="card mt-6 overflow-hidden">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <div>
                <h2 class="font-display text-lg font-semibold">Masukan dari pengunjung</h2>
                <p class="text-xs text-slate-500">Pesan yang dikirim lewat formulir kontak website.</p>
            </div>
            <span class="chip">{{ $stats['masukans'] }} pesan</span>
        </div>
        @if ($masukans->isEmpty())
            <p class="px-6 py-10 text-center text-sm text-slate-400">Belum ada masukan.</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach ($masukans as $masukan)
                    <li class="flex gap-4 px-6 py-4">
                        <span class="grid h-10 w-10 shrink-0 place-content-center rounded-full bg-brand-50 text-sm font-bold uppercase text-brand-700">{{ mb_substr($masukan->nama, 0, 1) }}</span>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                <p class="text-sm font-semibold text-brand-950">{{ $masukan->nama }}</p>
                                <a href="mailto:{{ $masukan->email }}" class="text-xs text-brand-600 hover:underline">{{ $masukan->email }}</a>
                                <span class="text-xs text-slate-400">{{ $masukan->created_at?->diffForHumans() }}</span>
                            </div>
                            <p class="mt-1 whitespace-pre-line text-sm text-slate-600">{{ $masukan->masukan }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.feedback.destroy', $masukan) }}" data-confirm="Masukan dari {{ $masukan->nama }} akan dihapus.">
                            @csrf @method('DELETE')
                            <button class="grid h-9 w-9 place-content-center rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-600" aria-label="Hapus"><x-icon name="trash" class="h-4 w-4" /></button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <div class="border-t border-slate-100 px-6 py-4">{{ $masukans->links() }}</div>
        @endif
    </div>
@endsection
