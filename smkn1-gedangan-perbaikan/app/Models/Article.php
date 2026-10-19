<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use FlushesSiteCache, HasFactory;

    public const PRESTASI = 'prestasi';

    protected $fillable = ['title', 'slug', 'writer_id', 'text_content', 'image'];

    protected function casts(): array
    {
        return ['view' => 'integer'];
    }

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'kategori_artikel')->withTimestamps();
    }

    public function scopePrestasi(Builder $query, bool $only = true): Builder
    {
        $filter = fn (Builder $q) => $q->whereRaw('LOWER(nama) = ?', [self::PRESTASI]);

        return $only ? $query->whereHas('kategoris', $filter) : $query->whereDoesntHave('kategoris', $filter);
    }

    public function excerpt(int $words = 25): string
    {
        $text = html_entity_decode(strip_tags($this->text_content), ENT_QUOTES | ENT_HTML5);

        return Str::words(trim(preg_replace('/\s+/u', ' ', str_replace("\u{00A0}", ' ', $text))), $words);
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        $i = 2;

        while (static::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
