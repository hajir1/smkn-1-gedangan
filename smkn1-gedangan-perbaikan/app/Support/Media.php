<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Helper untuk menampilkan file gambar yang tersimpan di disk "public".
 */
class Media
{
    /**
     * Folder lama di public/img yang dulu dipakai beberapa fitur update foto.
     * Dipertahankan agar foto lama tetap tampil.
     */
    private const LEGACY_DIRS = ['img/galeri', 'img/ekstra', 'img/osis', 'img/bisnis'];

    public static function url(?string $path): ?string
    {
        if (blank($path) || str_contains($path, '..')) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        foreach (self::LEGACY_DIRS as $dir) {
            if (is_file(public_path($dir . '/' . basename($path)))) {
                return asset($dir . '/' . basename($path));
            }
        }

        return null;
    }
}
