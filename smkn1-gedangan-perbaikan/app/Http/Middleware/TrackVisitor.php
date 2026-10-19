<?php

namespace App\Http\Middleware;

use App\Models\StatistikPengunjung;
use App\Services\TelegramNotifier;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mencatat 1 kunjungan per IP + browser per hari.
 *
 * Perbaikan dari versi lama:
 * - Dulu middleware ini tidak pernah dipasang di route, jadi statistik tidak tercatat.
 * - Pengecekan duplikat memakai cache, tidak query database di setiap request.
 * - Notifikasi Telegram kelipatan 100 hanya dikirim sekali (dulu terkirim di
 *   setiap request selama jumlahnya tetap kelipatan 100).
 * - Pencatatan dilakukan setelah response terkirim, tidak memperlambat halaman.
 */
class TrackVisitor
{
    public function __construct(private readonly TelegramNotifier $telegram)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->isMethod('GET') || $request->user()?->isAdmin()) {
            return $response;
        }

        $ip = (string) $request->ip();
        $agent = mb_substr((string) $request->userAgent(), 0, 255);
        $key = 'visit:' . now()->toDateString() . ':' . sha1($ip . '|' . $agent);

        if (Cache::add($key, true, now()->endOfDay())) {
            app()->terminating(function () use ($ip, $agent) {
                StatistikPengunjung::query()->create([
                    'ip_address' => $ip,
                    'user_agent' => $agent,
                    'visited_at' => now(),
                ]);

                $total = StatistikPengunjung::query()->count();
                if ($total % 100 === 0) {
                    $this->telegram->send("Website SMKN 1 Gedangan telah dikunjungi {$total} kali (" . now()->format('d-m-Y H:i') . ').');
                }
            });
        }

        return $response;
    }
}
