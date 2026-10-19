<?php

namespace App\Models;
use App\Models\User;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sarana extends Model
{
    use FlushesSiteCache;
    protected $fillable = ["konten","penulis_id"];
    public function penulis() : BelongsTo {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
