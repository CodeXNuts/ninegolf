<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'seller_id',
        'user_id',
        'order_id',
        'order_detail_id',
        'user_stripe_connected_account_id',
        'payout_merchant_amount',
        'payout_admin_amount',
        'transfer_group',
        'merchant_desc',
        'admin_desc',
        'transaction_payload',
        'transaction_status'
    ];
}
