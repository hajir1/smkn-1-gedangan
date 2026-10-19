<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Masukan;
use App\Rules\Recaptcha;
use App\Services\TelegramNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, TelegramNotifier $telegram): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:100'],
            'masukan' => ['required', 'string', 'min:5', 'max:2000'],
            'g-recaptcha-response' => [new Recaptcha()],
        ], [
            'masukan.required' => 'Pesan wajib diisi.',
        ]);

        // Email diambil dari akun yang login, bukan dari input form,
        // sehingga tidak bisa dipalsukan.
        $masukan = Masukan::query()->create([
            'nama' => $data['nama'],
            'email' => $request->user()->email,
            'masukan' => $data['masukan'],
        ]);

        $telegram->sendLater("Masukan baru dari {$masukan->nama} <{$masukan->email}>\n\n{$masukan->masukan}");

        return redirect()->to(url()->previous() . '#kontak')
            ->with('success', 'Terima kasih! Pesan Anda sudah kami terima.');
    }
}
