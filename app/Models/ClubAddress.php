<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClubAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'club_id',
        'loc_name',
        'price',
        'price_unit',
        'address',
        'lat',
        'lng',
        'locType',
        'locFor'
    ];
}
