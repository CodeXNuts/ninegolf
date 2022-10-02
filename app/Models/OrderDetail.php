<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'club_id',
        'club_amount',
        'from_date',
        'from_time',
        'to_date',
        'to_time',
        'club_address_id',
        'club_address_amount',
        'days'
    ];

    protected $appends = ['formatted_from','formatted_to'];

    public function getFormattedFromAttribute()
    {
        return Carbon::parse($this->from)->toFormattedDateString();
    }
    public function getFormattedToAttribute()
    {
        return Carbon::parse($this->to)->toFormattedDateString();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function club()
    {
        return $this->hasOne(Club::class,'id','club_id');
    }

    public function clubAddress()
    {
       return $this->hasOne(ClubAddress::class,'id','club_address_id');
    }
}
