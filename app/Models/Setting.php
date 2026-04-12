<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'check_in_time',
        'check_out_time',
        'address',
        'latitude',
        'longitude',
        'radius',
        'app_name',
        'pwa_name',
        'app_logo',
        'app_favicon',
        'pwa_logo',
    ];
}
