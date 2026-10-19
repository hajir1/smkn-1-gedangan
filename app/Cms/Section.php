<?php

namespace App\Cms;

use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * Halaman yang isinya hanya satu baris data (Sejarah, Visi Misi, Jurusan, dst).
 */
final class Section
{
    /**
     * @param  class-string<Model>  $model
     * @param  Field[]  $fields
     * @param  array<string, Closure>  $related  data tambahan untuk halaman publik
     */
    public function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly string $group,
        public readonly string $model,
        public readonly array $fields,
        public readonly ?string $uri = null,
        public readonly ?string $publicRoute = null,
        public readonly ?string $partial = null,
        public readonly array $related = [],
        public readonly array $children = [],
        public readonly ?string $description = null,
    ) {
    }

    public function record(): Model
    {
        return $this->model::query()->first() ?? new $this->model();
    }

    public function titleField(): ?string
    {
        return collect($this->fields)->first(fn (Field $f) => $f->name === 'judul')?->name;
    }

    public function relatedData(): array
    {
        return array_map(fn (Closure $loader) => $loader(), $this->related);
    }
}
