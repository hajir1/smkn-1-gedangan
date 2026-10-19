<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use FlushesSiteCache;
    protected $fillable =["photo","judul"];
}
