<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_gateway_id',
        'amount',
        'transaction_id',
        'transaction_payload',
        'transaction_type',
        'transaction_status'
    ];
}
