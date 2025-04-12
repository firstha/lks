<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasApiTokensWithoutExpiration;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{

    use HasApiTokensWithoutExpiration;
    
    protected $guarded = [];
}
