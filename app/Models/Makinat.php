<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makinat extends Model
{
    protected $table = 'makinat';

    protected $fillable = [
        'targa', 'sqarim', 'agent_id'
    ];

    public function agent()
    {
        return $this->hasOne('App\Models\Agents', 'agent_id', 'id');
    }
}
