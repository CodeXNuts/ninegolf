<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClubList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'club_id',
        'name',
        'slug',
        'price',
        'priceUnit',
        'brand',
        'length',
        'flex',
        'loft',
        'is_adjustable',
        'is_set',
        'is_active'
    ];

    protected $with = ['clubImages'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function clubImages()
    {
        return $this->hasMany(ClubImage::class);
    }
}
