<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = ['id'];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

}