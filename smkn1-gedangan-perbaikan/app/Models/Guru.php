<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use FlushesSiteCache, HasFactory;
    protected $fillable = ["nama","photo","tugas"];
}
