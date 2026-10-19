<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use FlushesSiteCache;
    protected $fillable = ["konten","photo"];
}
