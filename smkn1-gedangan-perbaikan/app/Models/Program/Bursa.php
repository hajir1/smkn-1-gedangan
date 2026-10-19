<?php

namespace App\Models\Program;

use App\Models\User;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bursa extends Model
{
    use FlushesSiteCache;
    protected $fillable = ["konten","penulis_id"];
    public function penulis() : BelongsTo {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
