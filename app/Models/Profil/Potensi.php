<?php

namespace App\Models\Profil;

use App\Models\User;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Potensi extends Model
{
    use FlushesSiteCache;
    protected $fillable = ["penulis_id","konten"];
    public function penulis() : BelongsTo {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
