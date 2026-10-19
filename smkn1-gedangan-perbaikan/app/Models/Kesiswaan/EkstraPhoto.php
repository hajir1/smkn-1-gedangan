<?php

namespace App\Models\Kesiswaan;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class EkstraPhoto extends Model
{
    use FlushesSiteCache;
    protected $table = "ekstrakulikuler_photos";
    protected $fillable =["photo"];
}
