<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rroga extends Model
{

    protected $table = 'rroga';

    protected $fillable = [
        'punonjesi', 'shuma', 'data'
    ];
}
