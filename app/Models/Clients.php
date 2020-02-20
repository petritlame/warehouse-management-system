<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'emri','adressa','phone','pershkrimi','produktet', 'nipt'
    ];
}
