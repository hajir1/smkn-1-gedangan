<?php

namespace App\Models\Jurusan;

use App\Models\User;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Busana extends Model
{
    use FlushesSiteCache;
    protected $fillable =["judul","photo","konten","penulis_id","photo_kaprog","nama_kaprog","ket_kaprog"];
    public function penulis() : BelongsTo {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
