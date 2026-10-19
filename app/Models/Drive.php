<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use FlushesSiteCache;
    protected $fillable = ["link","judul"];
}
