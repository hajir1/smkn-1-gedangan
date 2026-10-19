<?php

namespace App\Models\Profil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Waka extends Model
{
    use FlushesSiteCache, HasFactory;
    protected $fillable = ["nama","photo","jabatan"];
}
