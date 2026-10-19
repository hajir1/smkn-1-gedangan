<?php

namespace App\Models\Kesiswaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use FlushesSiteCache, HasFactory;
    protected $fillable = ['nama','tingkat','juara','penyelenggara'];
}
