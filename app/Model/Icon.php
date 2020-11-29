<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = ['icon', 'title'];

    public function iconable()
    {
        return $this->morphTo();
    }
}
