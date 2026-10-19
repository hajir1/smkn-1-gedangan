<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validasi konten editor: tidak boleh kosong dan minimal sekian kata
 * (dihitung dari teks, bukan dari tag HTML).
 */
class RichText implements ValidationRule
{
    public function __construct(private readonly int $minWords = 20)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $text = trim(html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5));
        $text = preg_replace('/\s+/u', ' ', str_replace("\u{00A0}", ' ', $text));

        if ($text === '') {
            $fail('Konten tidak boleh kosong.');

            return;
        }

        $words = count(preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY));

        if ($words < $this->minWords) {
            $fail("Konten minimal {$this->minWords} kata (saat ini {$words} kata).");
        }
    }
}
