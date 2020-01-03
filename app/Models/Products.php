<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'emertimi','cmim_blerje','cmim_shitje','vlera_blerje','vlera_shitje', 'category_id'
    ];

}
