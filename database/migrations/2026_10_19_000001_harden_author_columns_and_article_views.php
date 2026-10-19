<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * 1. Kolom penulis_id / writer_id sebelumnya "onDelete cascade": jika akun admin
 *    dihapus, SELURUH konten yang terakhir ia edit (sejarah, visi misi, jurusan,
 *    artikel, dst) ikut terhapus. Sekarang diubah menjadi nullable + set null.
 * 2. Kolom articles.view diubah dari string ke integer.
 * 3. Index pada statistik_pengunjungs.visited_at untuk grafik dashboard.
 * 4. Admin lama yang belum terverifikasi emailnya ditandai terverifikasi agar
 *    tidak terkunci setelah verifikasi email benar-benar diaktifkan.
 */
return new class extends Migration
{
    private array $authorTables = [
        'sejarahs', 'potensis', 'rencanas', 'visi_misis', 'logos', 'deskripsi_komites',
        'struktur_organisasis', 'kerjas', 'peraturans', 'bisnis', 'industris', 'bursas',
        'sijas', 'dkvs', 'animasis', 'bogas', 'akuntansis', 'tkrs', 'busanas', 'pemetaans',
        'beasiswas', 'osis', 'ekstrakulikulers', 'saranas',
    ];

    public function up(): void
    {
        foreach ($this->authorTables as $table) {
            $this->makeNullable($table, 'penulis_id');
        }

        $this->makeNullable('articles', 'writer_id');

        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('view')->default(0)->change();
        });

        Schema::table('statistik_pengunjungs', function (Blueprint $table) {
            $table->index('visited_at');
        });

        DB::table('users')->where('role', 1)->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        // Sengaja tidak mengembalikan cascade delete karena berbahaya.
    }

    private function makeNullable(string $tableName, string $column): void
    {
        if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, $column)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($column) {
            $table->dropForeign([$column]);
        });

        Schema::table($tableName, function (Blueprint $table) use ($column) {
            $table->unsignedBigInteger($column)->nullable()->change();
            $table->foreign($column)->references('id')->on('users')->nullOnDelete();
        });
    }
};
