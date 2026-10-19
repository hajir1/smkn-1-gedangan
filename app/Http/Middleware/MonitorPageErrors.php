<?php

namespace App\Http\Middleware;

use App\Services\TelegramNotifier;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Kirim notifikasi Telegram saat terjadi error 500 (dan 404 jika diaktifkan).
 *
 * Versi lama memanggil $next($request) dua kali sehingga setiap request diproses
 * ganda (data bisa tersimpan dua kali) dan mengirim Telegram tanpa batas.
 */
class MonitorPageErrors
{
    public function __construct(private readonly TelegramNotifier $telegram)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $status = $response->getStatusCode();

        $watched = $status >= 500 || ($status === 404 && config('services.telegram.report_404'));

        // Maksimal 1 notifikasi per URL per jam supaya tidak spam.
        if ($watched && Cache::add('page-error:' . $status . ':' . sha1($request->path()), true, now()->addHour())) {
            $this->telegram->sendLater(implode("\n", [
                'Error terdeteksi',
                'url = ' . $request->fullUrl(),
                'status = ' . $status,
                'waktu = ' . now()->format('d-m-Y H:i:s'),
            ]));
        }

        return $response;
    }
}
