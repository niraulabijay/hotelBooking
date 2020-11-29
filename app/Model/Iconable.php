<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Iconable extends Model
{
    protected $fillable = ['icon_id', 'iconable_id', 'iconable_type'];

    
}
