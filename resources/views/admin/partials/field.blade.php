{{-- Input form otomatis dari definisi App\Cms\Field --}}
@php($id = 'f-' . $field->name)
<div>
    <label for="{{ $id }}" class="form-label">{{ $field->label }}</label>

    @switch($field->type)
        @case('richtext')
            @include('admin.partials.editor', ['name' => $field->name, 'value' => $record->{$field->name}])
            @break

        @case('image')
            @php($current = \App\Support\Media::url($record->{$field->name}))
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                <div class="h-36 w-36 shrink-0 overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-200">
                    <img id="{{ $id }}-preview" src="{{ $current }}" alt="" class="h-full w-full object-cover {{ $current ? '' : 'hidden' }}">
                    <div class="media-placeholder h-full w-full {{ $current ? 'hidden' : '' }}"><x-icon name="photo" class="h-8 w-8" /></div>
                </div>
                <div class="flex-1">
                    <input id="{{ $id }}" type="file" name="{{ $field->name }}" accept="image/jpeg,image/png,image/webp" data-preview="#{{ $id }}-preview"
                           class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand-800 hover:file:bg-brand-100"
                           @if($field->required && ! $current) required @endif>
                    <p class="form-help">{{ $field->help }} {{ $current ? 'Kosongkan jika tidak ingin mengganti.' : '' }}</p>
                </div>
            </div>
            @break

        @default
            <input id="{{ $id }}" type="{{ $field->type === 'url' ? 'url' : 'text' }}" name="{{ $field->name }}"
                   value="{{ old($field->name, $record->{$field->name}) }}" class="form-input" required
                   @if($field->type === 'url') placeholder="https://" @endif>
    @endswitch

    @error($field->name) <p class="form-error">{{ $message }}</p> @enderror
</div>
