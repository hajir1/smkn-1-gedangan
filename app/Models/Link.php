<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use FlushesSiteCache;
    protected $fillable =["facebook","instagram","tiktok","website"];
}
