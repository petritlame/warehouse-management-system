<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arka extends Model
{
    protected $fillable = [
        'data', 'nr_arketimi', 'nr_pagese', 'shpjegmi', 'hyrjet', 'daljet'
    ];
}
