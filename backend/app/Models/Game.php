<?php

namespace App\Models;

use App\Models\GameVersion;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    public function gameVersions()
    {
        return $this->hasMany(GameVersion::class);
    }
}
