<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Verifikasi Google reCAPTCHA v2 ke server Google.
 *
 * Sebelumnya aplikasi hanya mengecek field "g-recaptcha-response" terisi,
 * sehingga bot cukup mengirim teks apa saja untuk melewati captcha.
 */
class Recaptcha implements ValidationRule
{
    /** Tetap dijalankan walaupun field kosong / tidak dikirim. */
    public bool $implicit = true;

    public static function enabled(): bool
    {
        return filled(config('captcha.secret')) && filled(config('captcha.sitekey'));
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! self::enabled()) {
            // Hanya boleh dilewati di lingkungan lokal/testing.
            if (! app()->environment(['local', 'testing'])) {
                $fail('Captcha belum dikonfigurasi. Hubungi admin.');
            }

            return;
        }

        if (blank($value)) {
            $fail('Silakan centang captcha terlebih dahulu.');

            return;
        }

        try {
            $response = Http::asForm()->timeout(8)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('captcha.secret'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            if (! $response->json('success')) {
                $fail('Verifikasi captcha gagal, silakan coba lagi.');
            }
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA error: ' . $e->getMessage());
            $fail('Captcha tidak dapat diverifikasi, silakan coba lagi.');
        }
    }
}
