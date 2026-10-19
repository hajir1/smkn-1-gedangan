<?php

use App\Cms\Registry;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\ExternalLinkController;
use App\Http\Controllers\Frontend\FeedbackController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ListingController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website publik
|--------------------------------------------------------------------------
| URL dan nama route sama seperti versi lama (mis. /profil/sejarah => "sejarah")
| supaya link lama tetap berfungsi.
*/
Route::middleware('track-visitor')->group(function () {
    Route::get('/', HomeController::class)->name('welcome');
    Route::get('sambutan_kepsek', [ListingController::class, 'kepsek'])->name('sambutan_kepsek');

    // Semua halaman konten tunggal dibuat otomatis dari App\Cms\Registry.
    foreach (Registry::sections() as $section) {
        if ($section->uri) {
            Route::get($section->uri, PageController::class)
                ->defaults('section', $section->key)
                ->name($section->publicRoute);
        }
    }

    Route::prefix('kesiswaan')->group(function () {
        Route::get('prestasi', [ListingController::class, 'prestasi'])->name('prestasi');
    });

    Route::prefix('informasi')->group(function () {
        Route::get('guru', [ListingController::class, 'guru'])->name('guru');
        Route::get('galeri', [ListingController::class, 'galeri'])->name('galeri');
        Route::get('drive', [ListingController::class, 'drive'])->name('drive');
        Route::get('artikel', [ArticleController::class, 'index'])->name('artikel');
        Route::get('article/{slug}', [ArticleController::class, 'show'])->name('readArticle');
        Route::get('elearning', ExternalLinkController::class)->defaults('link', 'elearning')->name('elearning');
    });

    Route::prefix('ppdb')->group(function () {
        Route::get('jadwal', ExternalLinkController::class)->defaults('link', 'jadwal')->name('jadwal');
        Route::get('info_ppdb', ExternalLinkController::class)->defaults('link', 'info_ppdb')->name('info_ppdb');
        Route::get('survey', ExternalLinkController::class)->defaults('link', 'survey')->name('survey');
    });
});

// Form kontak hanya untuk pengguna yang sudah login & verifikasi email.
Route::post('save_masukan', [FeedbackController::class, 'store'])
    ->middleware(['auth', 'verified', 'throttle:feedback'])
    ->name('save_masukan');

/*
|--------------------------------------------------------------------------
| Dashboard admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin', 'no-store'])->prefix('be')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('masukan/{masukan}', [DashboardController::class, 'destroyFeedback'])->name('admin.feedback.destroy');

    Route::name('admin.')->group(function () {
        Route::resource('artikel', AdminArticleController::class)
            ->parameters(['artikel' => 'artikel'])
            ->names('articles');

        $sections = implode('|', array_map('preg_quote', array_keys(Registry::sections())));
        Route::controller(SectionController::class)->prefix('halaman/{section}')->where(['section' => $sections])->group(function () {
            Route::get('/', 'show')->name('sections.show');
            Route::get('edit', 'edit')->name('sections.edit');
            Route::put('/', 'update')->name('sections.update');
        });

        $collections = implode('|', array_map('preg_quote', array_keys(Registry::collections())));
        Route::controller(CollectionController::class)->prefix('data/{collection}')->where(['collection' => $collections, 'id' => '[0-9]+'])->group(function () {
            Route::get('/', 'index')->name('collections.index');
            Route::get('tambah', 'create')->name('collections.create');
            Route::post('/', 'store')->name('collections.store');
            Route::get('{id}/edit', 'edit')->name('collections.edit');
            Route::put('{id}', 'update')->name('collections.update');
            Route::delete('{id}', 'destroy')->name('collections.destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
