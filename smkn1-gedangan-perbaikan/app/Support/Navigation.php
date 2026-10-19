<?php

namespace App\Support;

use App\Cms\Registry;

/**
 * Menu utama website publik (navbar & footer memakai sumber yang sama).
 */
class Navigation
{
    public static function main(): array
    {
        $jurusan = collect(Registry::JURUSAN)
            ->map(fn ($item, $key) => ['route' => $key, 'label' => $item[1]])
            ->values()->all();

        return [
            ['label' => 'Profil', 'prefix' => 'profil', 'items' => [
                ['route' => 'sejarah', 'label' => 'Sejarah Sekolah'],
                ['route' => 'visi', 'label' => 'Visi dan Misi'],
                ['route' => 'potensi', 'label' => 'Potensi Unggulan'],
                ['route' => 'rencana', 'label' => 'Rencana Pengembangan'],
                ['route' => 'logo', 'label' => 'Logo Sekolah'],
                ['route' => 'komite', 'label' => 'Komite Sekolah'],
                ['route' => 'struktur', 'label' => 'Struktur Organisasi'],
                ['route' => 'sambutan_kepsek', 'label' => 'Sambutan Kepala Sekolah'],
            ]],
            ['label' => 'Program', 'prefix' => 'program', 'items' => [
                ['route' => 'kerja', 'label' => 'Program Kerja'],
                ['route' => 'peraturan', 'label' => 'Peraturan Sekolah'],
                ['route' => 'bisnis', 'label' => 'Program Bisnis'],
                ['route' => 'industri', 'label' => 'Hubungan Industri'],
                ['route' => 'bursa', 'label' => 'Bursa Kerja Khusus'],
            ]],
            ['label' => 'Jurusan', 'prefix' => 'jurusan', 'items' => $jurusan],
            ['label' => 'Kesiswaan', 'prefix' => 'kesiswaan', 'items' => [
                ['route' => 'prestasi', 'label' => 'Prestasi Siswa'],
                ['route' => 'ekstrakulikuler', 'label' => 'Ekstrakurikuler'],
                ['route' => 'osis', 'label' => 'OSIS'],
                ['route' => 'beasiswa', 'label' => 'Beasiswa'],
            ]],
            ['label' => 'Informasi', 'prefix' => 'informasi', 'items' => [
                ['route' => 'artikel', 'label' => 'Berita & Artikel'],
                ['route' => 'guru', 'label' => 'Guru & Tendik'],
                ['route' => 'galeri', 'label' => 'Galeri'],
                ['route' => 'sarana', 'label' => 'Sarana Prasarana'],
                ['route' => 'drive', 'label' => 'Drive Dokumen'],
                ['route' => 'elearning', 'label' => 'E-Learning', 'external' => true],
            ]],
            ['label' => 'PPDB', 'prefix' => 'ppdb', 'items' => [
                ['route' => 'info_ppdb', 'label' => 'Informasi PPDB', 'external' => true],
                ['route' => 'jadwal', 'label' => 'Jadwal PPDB', 'external' => true],
                ['route' => 'survey', 'label' => 'Survey Peminatan', 'external' => true],
            ]],
        ];
    }
}
