<?php

namespace App\Cms;

use App\Models\Drive;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Jurusan\Akuntansi;
use App\Models\Jurusan\Animasi;
use App\Models\Jurusan\Boga;
use App\Models\Jurusan\Busana;
use App\Models\Jurusan\Dkv;
use App\Models\Jurusan\Sija;
use App\Models\Jurusan\Tkr;
use App\Models\Kepsek;
use App\Models\Kesiswaan\Beasiswa;
use App\Models\Kesiswaan\Ekstrakulikuler;
use App\Models\Kesiswaan\EkstraPhoto;
use App\Models\Kesiswaan\Osis;
use App\Models\Kesiswaan\OsisPhoto;
use App\Models\Kesiswaan\Prestasi;
use App\Models\Link;
use App\Models\Profil;
use App\Models\Profil\DeskripsiKomite;
use App\Models\Profil\KetuaKomite;
use App\Models\Profil\Komite;
use App\Models\Profil\Logo;
use App\Models\Profil\Potensi;
use App\Models\Profil\Rencana;
use App\Models\Profil\Sejarah;
use App\Models\Profil\StrukturOrganisasi;
use App\Models\Profil\VisiMisi;
use App\Models\Profil\Waka;
use App\Models\Program\Bisnis;
use App\Models\Program\BisnisPhoto;
use App\Models\Program\Bursa;
use App\Models\Program\Industri;
use App\Models\Program\Kerja;
use App\Models\Program\Peraturan;
use App\Models\Sarana;

/**
 * Daftar seluruh konten website di satu tempat.
 *
 * Menambah halaman baru cukup dengan menambah satu entri di sini: route publik,
 * menu dashboard, form edit dan validasinya akan ikut terbentuk.
 */
final class Registry
{
    /** @var array<string, Section>|null */
    private static ?array $sections = null;

    /** @var array<string, Collection>|null */
    private static ?array $collections = null;

    /** Program keahlian: key route => [model, nama]. */
    public const JURUSAN = [
        'sija' => [Sija::class, 'Sistem Informatika, Jaringan & Aplikasi'],
        'dkv' => [Dkv::class, 'Desain Komunikasi Visual'],
        'animasi' => [Animasi::class, 'Animasi'],
        'boga' => [Boga::class, 'Kuliner'],
        'akuntansi' => [Akuntansi::class, 'Akuntansi'],
        'busana' => [Busana::class, 'Desain & Produksi Busana'],
        'tkr' => [Tkr::class, 'Teknik Kendaraan Ringan'],
    ];

    /** Urutan grup menu. */
    public const GROUPS = ['Beranda', 'Profil', 'Program', 'Jurusan', 'Kesiswaan', 'Informasi'];

    /** @return array<string, Section> */
    public static function sections(): array
    {
        if (self::$sections !== null) {
            return self::$sections;
        }

        $konten = fn () => Field::richtext('konten', 'Konten');
        $foto = fn (string $dir, string $label = 'Foto') => Field::image('photo', $label, $dir);

        $list = [
            // Beranda
            new Section('profil', 'Profil Beranda', 'Beranda', Profil::class,
                [$foto('welcome', 'Foto Profil'), $konten()],
                publicRoute: 'welcome', description: 'Teks dan foto profil singkat di halaman utama.'),
            new Section('kepsek', 'Kepala Sekolah', 'Beranda', Kepsek::class,
                [Field::text('nama', 'Nama Kepala Sekolah', 3), $foto('kepala_sekolah'), Field::richtext('sambutan', 'Sambutan')],
                publicRoute: 'sambutan_kepsek', description: 'Foto dan sambutan kepala sekolah.'),
            new Section('link', 'Media Sosial', 'Beranda', Link::class,
                [Field::url('facebook', 'Facebook'), Field::url('instagram', 'Instagram'), Field::url('tiktok', 'TikTok'), Field::url('website', 'Website / YouTube')],
                description: 'Tautan media sosial di header dan footer.'),

            // Profil
            new Section('sejarah', 'Sejarah', 'Profil', Sejarah::class, [$foto('profil'), $konten()], 'profil/sejarah', 'sejarah'),
            new Section('potensi', 'Potensi Unggulan', 'Profil', Potensi::class, [$konten()], 'profil/potensi', 'potensi'),
            new Section('rencana', 'Rencana Pengembangan', 'Profil', Rencana::class, [$konten()], 'profil/rencana', 'rencana'),
            new Section('visi', 'Visi dan Misi', 'Profil', VisiMisi::class, [$konten()], 'profil/visi', 'visi'),
            new Section('logo', 'Logo Sekolah', 'Profil', Logo::class, [$foto('profil', 'Gambar Logo'), Field::richtext('konten', 'Makna Logo')], 'profil/logo', 'logo'),
            new Section('komite', 'Komite Sekolah', 'Profil', DeskripsiKomite::class, [Field::richtext('konten', 'Deskripsi Komite')],
                'profil/komite', 'komite', 'komite',
                related: [
                    'ketua' => fn () => KetuaKomite::query()->first(),
                    'people' => fn () => Komite::query()->latest()->get(),
                ],
                children: ['ketua-komite', 'anggota-komite']),
            new Section('ketua-komite', 'Ketua Komite', 'Profil', KetuaKomite::class,
                [Field::text('nama', 'Nama', 3), Field::text('jabatan', 'Jabatan'), $foto('komite')],
                publicRoute: 'komite', description: 'Ditampilkan di halaman Komite Sekolah.'),
            new Section('struktur', 'Struktur Organisasi', 'Profil', StrukturOrganisasi::class, [$foto('profil', 'Bagan Struktur'), $konten()],
                'profil/struktur', 'struktur', 'people',
                related: ['people' => fn () => Waka::query()->oldest()->get()],
                children: ['waka']),

            // Program
            new Section('kerja', 'Program Kerja', 'Program', Kerja::class, [$konten()], 'program/kerja', 'kerja'),
            new Section('peraturan', 'Peraturan Sekolah', 'Program', Peraturan::class, [$konten()], 'program/peraturan', 'peraturan'),
            new Section('bisnis', 'Program Bisnis', 'Program', Bisnis::class, [$konten()], 'program/bisnis', 'bisnis', 'gallery',
                related: ['photos' => fn () => BisnisPhoto::query()->latest()->get()], children: ['foto-bisnis']),
            new Section('industri', 'Hubungan Industri', 'Program', Industri::class, [$konten()], 'program/industri', 'industri'),
            new Section('bursa', 'Bursa Kerja', 'Program', Bursa::class, [$konten()], 'program/bursa', 'bursa'),

            // Kesiswaan
            new Section('ekstrakulikuler', 'Ekstrakurikuler', 'Kesiswaan', Ekstrakulikuler::class, [$konten()], 'kesiswaan/ekstrakulikuler', 'ekstrakulikuler', 'gallery',
                related: ['photos' => fn () => EkstraPhoto::query()->latest()->get()], children: ['foto-ekstrakurikuler']),
            new Section('osis', 'OSIS', 'Kesiswaan', Osis::class, [$konten()], 'kesiswaan/osis', 'osis', 'people',
                related: ['people' => fn () => OsisPhoto::query()->oldest()->get()], children: ['pengurus-osis']),
            new Section('beasiswa', 'Beasiswa', 'Kesiswaan', Beasiswa::class, [$konten()], 'kesiswaan/beasiswa', 'beasiswa'),

            // Informasi
            new Section('sarana', 'Sarana Prasarana', 'Informasi', Sarana::class, [$konten()], 'informasi/sarana', 'sarana'),
        ];

        foreach (self::JURUSAN as $key => [$model, $label]) {
            $list[] = new Section($key, $label, 'Jurusan', $model, [
                Field::text('judul', 'Nama Jurusan', 3),
                Field::image('photo', 'Foto Jurusan', 'jurusan'),
                $konten(),
                Field::text('nama_kaprog', 'Nama Kepala Program', 3),
                Field::text('ket_kaprog', 'Jabatan / Kompetensi', 3),
                Field::image('photo_kaprog', 'Foto Kepala Program', 'jurusan', required: false),
            ], "jurusan/$key", $key, 'jurusan');
        }

        return self::$sections = collect($list)->keyBy('key')->all();
    }

    /** @return array<string, Collection> */
    public static function collections(): array
    {
        if (self::$collections !== null) {
            return self::$collections;
        }

        $nama = fn () => Field::text('nama', 'Nama', 3);
        $jabatan = fn () => Field::text('jabatan', 'Jabatan');

        $list = [
            new Collection('guru', 'Guru & Tendik', 'Guru', 'Informasi', Guru::class,
                [$nama(), Field::text('tugas', 'Tugas / Mapel'), Field::image('photo', 'Foto', 'guru')], publicRoute: 'guru', layout: 'cards'),
            new Collection('galeri', 'Galeri', 'Foto Galeri', 'Informasi', Galeri::class,
                [Field::text('judul', 'Judul', 3), Field::image('photo', 'Foto', 'galeri')], publicRoute: 'galeri', layout: 'cards'),
            new Collection('drive', 'Drive', 'Link Drive', 'Informasi', Drive::class,
                [Field::text('judul', 'Judul', 3), Field::url('link', 'Link')], publicRoute: 'drive'),
            new Collection('prestasi', 'Prestasi Siswa', 'Prestasi', 'Kesiswaan', Prestasi::class,
                [Field::text('nama', 'Nama Lomba / Siswa', 1), Field::text('juara', 'Juara', 1), Field::text('tingkat', 'Tingkat', 1), Field::text('penyelenggara', 'Penyelenggara', 1)],
                publicRoute: 'prestasi'),
            new Collection('waka', 'Wakil Kepala Sekolah', 'Waka', 'Profil', Waka::class,
                [$nama(), $jabatan(), Field::image('photo', 'Foto', 'waka')], 'struktur', 'struktur', 'cards'),
            new Collection('anggota-komite', 'Anggota Komite', 'Anggota Komite', 'Profil', Komite::class,
                [$nama(), $jabatan(), Field::image('photo', 'Foto', 'komite')], 'komite', 'komite', 'cards'),
            new Collection('pengurus-osis', 'Pengurus OSIS', 'Pengurus OSIS', 'Kesiswaan', OsisPhoto::class,
                [$nama(), $jabatan(), Field::image('photo', 'Foto', 'osis')], 'osis', 'osis', 'cards'),
            new Collection('foto-ekstrakurikuler', 'Foto Ekstrakurikuler', 'Foto', 'Kesiswaan', EkstraPhoto::class,
                [Field::image('photo', 'Foto', 'ekstra')], 'ekstrakulikuler', 'ekstrakulikuler', 'cards'),
            new Collection('foto-bisnis', 'Foto Program Bisnis', 'Foto', 'Program', BisnisPhoto::class,
                [Field::image('photo', 'Foto', 'bisnis')], 'bisnis', 'bisnis', 'cards'),
        ];

        return self::$collections = collect($list)->keyBy('key')->all();
    }

    public static function section(string $key): Section
    {
        return self::sections()[$key] ?? abort(404);
    }

    public static function collection(string $key): Collection
    {
        return self::collections()[$key] ?? abort(404);
    }

    /**
     * Menu dashboard: [grup => [[label, url, aktif?], ...]].
     */
    public static function menu(): array
    {
        $menu = array_fill_keys(self::GROUPS, []);

        foreach (self::sections() as $section) {
            if (in_array($section->key, ['ketua-komite'], true)) {
                continue; // dikelola dari halaman Komite
            }
            $menu[$section->group][] = [
                'label' => $section->label,
                'url' => route('admin.sections.show', $section->key),
                'active' => request()->routeIs('admin.sections.*') && request()->route('section') === $section->key
                    || in_array(request()->route('collection'), $section->children, true)
                    || in_array(request()->route('section'), $section->children, true),
            ];
        }

        foreach (self::collections() as $collection) {
            if ($collection->parent) {
                continue; // tampil sebagai bagian dari halaman induknya
            }
            $menu[$collection->group][] = [
                'label' => $collection->label,
                'url' => route('admin.collections.index', $collection->key),
                'active' => request()->route('collection') === $collection->key,
            ];
        }

        return array_filter($menu);
    }
}
