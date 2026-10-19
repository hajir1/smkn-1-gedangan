<?php

namespace App\Cms;

use App\Services\HtmlSanitizer;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Validasi + simpan data berdasarkan definisi Field.
 * Dipakai oleh semua halaman konten dan data daftar di dashboard.
 */
class ContentWriter
{
    public function __construct(
        private readonly ImageService $images,
        private readonly HtmlSanitizer $sanitizer,
    ) {
    }

    /**
     * @param  Field[]  $fields
     */
    public function validate(Request $request, array $fields, ?Model $model = null): array
    {
        $rules = [];
        foreach ($fields as $field) {
            $rules[$field->name] = $field->rulesFor($model);
        }

        $attributes = collect($fields)->mapWithKeys(fn (Field $f) => [$f->name => strtolower($f->label)])->all();

        return $request->validate($rules, [], $attributes);
    }

    /**
     * @param  Field[]  $fields
     */
    public function save(Model $model, array $fields, Request $request): Model
    {
        $data = $this->validate($request, $fields, $model->exists ? $model : null);
        $newImages = [];

        foreach ($fields as $field) {
            if ($field->isImage()) {
                if ($request->hasFile($field->name)) {
                    $old = $model->{$field->name};
                    $model->{$field->name} = $this->images->store($request->file($field->name), $field->directory);
                    $newImages[$field->name] = $old;
                }

                continue;
            }

            $value = $data[$field->name] ?? null;
            $model->{$field->name} = $field->type === 'richtext' ? $this->sanitizer->clean($value) : $value;
        }

        if ($this->hasColumn($model, 'penulis_id')) {
            $model->penulis_id = $request->user()?->id;
        }

        $model->save();

        // Gambar lama baru dihapus setelah data berhasil disimpan.
        foreach ($newImages as $old) {
            $this->images->delete($old);
        }

        return $model;
    }

    /**
     * @param  Field[]  $fields
     */
    public function delete(Model $model, array $fields): void
    {
        $model->delete();

        foreach ($fields as $field) {
            if ($field->isImage()) {
                $this->images->delete($model->{$field->name});
            }
        }
    }

    private function hasColumn(Model $model, string $column): bool
    {
        static $cache = [];

        return $cache[$model->getTable()][$column] ??= Schema::hasColumn($model->getTable(), $column);
    }
}
