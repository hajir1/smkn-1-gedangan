<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\TelegramNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request, TelegramNotifier $telegram): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        if (! $user->isAdmin()) {
            if (! $user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')
                    ->with('error', 'Silakan verifikasi email Anda terlebih dahulu.');
            }

            return redirect()->intended(route('welcome'))->with('success', 'Anda berhasil login.');
        }

        // Notifikasi login admin dikirim setelah response, tidak memperlambat login.
        $telegram->sendLater(
            "Login admin pada " . now()->format('d-m-Y H:i') . "\nUser: {$user->name}\nEmail: {$user->email}\nIP: {$request->ip()}"
        );

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
