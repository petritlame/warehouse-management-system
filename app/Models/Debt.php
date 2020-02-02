<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'debt';

    protected $fillable = [
        'value', 'pershkrimi', 'status'
    ];
}
