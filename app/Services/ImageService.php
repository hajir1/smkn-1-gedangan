<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

/**
 * Satu-satunya tempat untuk menyimpan, mengganti dan menghapus gambar upload.
 *
 * - Nama file selalu acak (hashName), tidak pernah memakai nama asli dari
 *   pengguna, sehingga file seperti "shell.php" tidak bisa ditanam di server.
 * - File disimpan di storage/app/public dan (opsional) disalin ke folder backup
 *   yang diatur lewat BACKUP_PHOTOS di .env.
 */
class ImageService
{
    public function __construct(private readonly ?string $backupRoot = null)
    {
    }

    public function store(UploadedFile $file, string $directory): string
    {
        $path = $file->store(trim($directory, '/'), 'public');

        if (! $path) {
            throw new RuntimeException('Gambar gagal disimpan.');
        }

        $this->backup($path);

        return $path;
    }

    /**
     * Simpan file baru dulu, baru hapus file lama. Jika penyimpanan gagal,
     * gambar lama tetap aman.
     */
    public function replace(?string $oldPath, UploadedFile $file, string $directory): string
    {
        $newPath = $this->store($file, $directory);
        $this->delete($oldPath);

        return $newPath;
    }

    public function delete(?string $path): void
    {
        if (blank($path) || str_contains($path, '..')) {
            return;
        }

        $path = ltrim($path, '/');
        Storage::disk('public')->delete($path);

        if ($this->backupRoot) {
            File::delete($this->backupPath($path));
        }
    }

    private function backup(string $path): void
    {
        if (! $this->backupRoot) {
            return;
        }

        $target = $this->backupPath($path);

        try {
            File::ensureDirectoryExists(dirname($target), 0755);
            File::copy(Storage::disk('public')->path($path), $target);
        } catch (\Throwable $e) {
            // Backup gagal tidak boleh membatalkan upload utama.
            Log::warning('Backup gambar gagal: ' . $e->getMessage(), ['path' => $path]);
        }
    }

    private function backupPath(string $path): string
    {
        return rtrim($this->backupRoot, '/\\') . DIRECTORY_SEPARATOR . $path;
    }
}
