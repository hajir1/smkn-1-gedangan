<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Redirect ke website lain (E-learning, Survey, PPDB). Tautan diatur di
 * config/school.php. Dulu jadwal & info PPDB redirect ke "" sehingga error.
 */
class ExternalLinkController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $key = $request->route()->defaults['link'];
        $url = config("school.links.$key");

        if (blank($url)) {
            return redirect()->route('welcome')->with('info', 'Informasi ini akan segera tersedia. Silakan cek kembali nanti.');
        }

        return redirect()->away($url);
    }
}
