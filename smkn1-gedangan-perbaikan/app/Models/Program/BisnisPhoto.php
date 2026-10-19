<?php

namespace App\Models\Program;

use App\Models\User;
use App\Models\Concerns\FlushesSiteCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BisnisPhoto extends Model
{
    use FlushesSiteCache;
    protected $fillable =["photo"];
    
}
