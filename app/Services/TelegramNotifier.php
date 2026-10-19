<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Kirim notifikasi ke Telegram tanpa memperlambat atau menggagalkan request.
 *
 * Pesan dikirim setelah response terkirim ke browser (terminating callback),
 * memakai timeout pendek, dan semua error hanya dicatat ke log.
 */
class TelegramNotifier
{
    public function __construct(
        private readonly ?string $token,
        private readonly ?string $chatId,
    ) {
    }

    public function enabled(): bool
    {
        return filled($this->token) && filled($this->chatId);
    }

    public function sendLater(string $text): void
    {
        if (! $this->enabled()) {
            return;
        }

        app()->terminating(fn () => $this->send($text));
    }

    public function send(string $text): bool
    {
        if (! $this->enabled()) {
            return false;
        }

        try {
            $response = Http::timeout(5)->asForm()->post(
                "https://api.telegram.org/bot{$this->token}/sendMessage",
                ['chat_id' => $this->chatId, 'text' => mb_substr($text, 0, 4000)]
            );

            if ($response->failed()) {
                Log::warning('Telegram gagal: ' . $response->status());
            }

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning('Telegram error: ' . $e->getMessage());

            return false;
        }
    }
}
