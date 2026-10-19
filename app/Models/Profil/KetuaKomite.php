<?php

namespace App\Models\Profil;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class KetuaKomite extends Model
{
    use FlushesSiteCache;
    protected $fillable = ["nama","photo","jabatan"];
}
