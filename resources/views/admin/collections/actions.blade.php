<div class="inline-flex shrink-0 items-center gap-1">
    <a href="{{ route('admin.collections.edit', [$collection->key, $item->id]) }}" class="grid h-8 w-8 place-content-center rounded-lg text-slate-500 hover:bg-brand-50 hover:text-brand-800" aria-label="Ubah">
        <x-icon name="pencil" class="h-4 w-4" />
    </a>
    <form method="POST" action="{{ route('admin.collections.destroy', [$collection->key, $item->id]) }}" data-confirm="{{ $collection->singular }} ini akan dihapus permanen.">
        @csrf @method('DELETE')
        <button class="grid h-8 w-8 place-content-center rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600" aria-label="Hapus"><x-icon name="trash" class="h-4 w-4" /></button>
    </form>
</div>
