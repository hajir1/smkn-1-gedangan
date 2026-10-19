<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori extends Model
{
    use FlushesSiteCache;
    protected $fillable = ["nama"];
    public function articles() : BelongsToMany {
        return $this->belongsToMany(Article::class,"kategori_artikel");
    }
}
