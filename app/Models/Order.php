<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'order_serial',
        'user_id',
        'amount',
        'status',
        'order_state'
    ];
    
    protected $appends = ['order_month','formatted_from','formatted_to','formatted_created_at'];

    public function getOrderMonthAttribute()
    {
        return $this->created_at->format('M');
    }

    public function getFormattedFromAttribute()
    {
        return Carbon::parse($this->from)->toFormattedDateString();
    }
    public function getFormattedToAttribute()
    {
        return Carbon::parse($this->to)->toFormattedDateString();
    }
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->toFormattedDateString();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
       return $this->hasMany(OrderDetail::class);
    }

    public function orderTransaction()
    {
        return $this->hasOne(OrderTransaction::class);
    }
    
}
