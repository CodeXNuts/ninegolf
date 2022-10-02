<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        
    ];

    public function club()
    {
        return $this->hasOne(Club::class,'id','club_id');
    }

    public function cartItems()
    {
       return $this->hasMany(CartItem::class);
    }
}