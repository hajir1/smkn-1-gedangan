<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * Data berbentuk daftar (Guru, Galeri, Prestasi, Komite, dst).
 */
final class Collection
{
    /**
     * @param  class-string<Model>  $model
     * @param  Field[]  $fields
     */
    public function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly string $singular,
        public readonly string $group,
        public readonly string $model,
        public readonly array $fields,
        public readonly ?string $parent = null,
        public readonly ?string $publicRoute = null,
        public readonly string $layout = 'table',
    ) {
    }

    public function find(int|string $id): Model
    {
        return $this->model::query()->findOrFail($id);
    }

    public function imageField(): ?Field
    {
        return collect($this->fields)->first(fn (Field $f) => $f->isImage());
    }

    /** @return Field[] */
    public function textFields(): array
    {
        return array_values(array_filter($this->fields, fn (Field $f) => ! $f->isImage()));
    }
}
