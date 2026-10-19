<?php

namespace App\Cms;

use App\Rules\RichText;
use Illuminate\Database\Eloquent\Model;

/**
 * Definisi satu input form di dashboard (teks, gambar, editor, url, dsb).
 * Dari definisi ini form, aturan validasi dan proses simpan dibuat otomatis.
 */
final class Field
{
    private function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $label,
        public readonly array $rules = [],
        public readonly ?string $directory = null,
        public readonly bool $required = true,
        public readonly ?string $help = null,
    ) {
    }

    public static function text(string $name, string $label, int $min = 3, int $max = 100, ?string $help = null): self
    {
        return new self($name, 'text', $label, ['required', 'string', "min:$min", "max:$max"], help: $help);
    }

    public static function url(string $name, string $label): self
    {
        return new self($name, 'url', $label, ['required', 'string', 'max:2000', 'url:http,https']);
    }

    public static function richtext(string $name, string $label, int $minWords = 20): self
    {
        return new self($name, 'richtext', $label, ['required', 'string', 'max:65000', new RichText($minWords)]);
    }

    public static function image(string $name, string $label, string $directory, bool $required = true): self
    {
        return new self($name, 'image', $label, [], $directory, $required,
            'Format JPG, PNG atau WEBP, maksimal 5 MB.');
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    /**
     * Gambar wajib diisi hanya jika field-nya wajib dan data belum punya gambar.
     */
    public function rulesFor(?Model $model = null): array
    {
        if (! $this->isImage()) {
            return $this->rules;
        }

        $hasImage = $model && filled($model->{$this->name});
        $presence = $this->required && ! $hasImage ? 'required' : 'nullable';

        return [$presence, 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
    }
}
