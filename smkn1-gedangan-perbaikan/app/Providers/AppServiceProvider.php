<?php

namespace App\Providers;

use App\Models\Link;
use App\Services\ImageService;
use App\Services\TelegramNotifier;
use App\Support\SiteCache;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageService::class, fn () => new ImageService(config('filesystems.backup_path')));

        $this->app->singleton(TelegramNotifier::class, fn () => new TelegramNotifier(
            config('services.telegram.bot_token'),
            config('services.telegram.chat_id'),
        ));
    }

    public function boot(): void
    {
        Carbon::setLocale('id');
        Paginator::defaultView('vendor.pagination.site');

        // Data media sosial dipakai di header & footer semua halaman publik.
        View::composer(['frontend.partials.topbar', 'frontend.partials.footer'], function ($view) {
            $view->with('social', SiteCache::remember('social-links', fn () => Link::query()->first()));
        });

        RateLimiter::for('feedback', fn (Request $request) => [
            Limit::perMinutes(10, 1)->by('feedback:' . ($request->user()?->id ?: $request->ip())),
        ]);

        RateLimiter::for('register', fn (Request $request) => Limit::perHour(5)->by($request->ip()));

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Email - SMK Negeri 1 Gedangan')
                ->greeting('Halo, ' . $notifiable->name)
                ->line('Terima kasih telah mendaftar akun di website resmi SMK Negeri 1 Gedangan. Klik tombol di bawah ini untuk memverifikasi email Anda.')
                ->action('Verifikasi Email', $url);
        });
    }
}
