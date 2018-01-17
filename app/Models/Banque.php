<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    protected $table = 'banques';

    protected $fillable = ['nom', 'logo'];
}
