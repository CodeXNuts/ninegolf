<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'club_id',
        'from_date',
        'from_time',
        'to_date',
        'to_time',
        'days',
        'club_address_id'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function club()
    {
        return $this->hasOne(Club::class, 'id', 'club_id');
    }

    public function clubAddress()
    {
        return $this->hasOne(ClubAddress::class,'id','club_address_id');
    }
}
