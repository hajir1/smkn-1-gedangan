<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Kepsek extends Model
{
    use FlushesSiteCache;
    protected $table = "kepsek";
    protected $fillable = ["nama","sambutan","photo"];
}
