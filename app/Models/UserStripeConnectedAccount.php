<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStripeConnectedAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_connected_account',
        'email',
        'company_country',
        'company_state',
        'company_city',
        'company_postal_code',
        'company_addr_line_1',
        'company_addr_line_2',
        'business_profile_name',
        'business_profile_desc',
        'ac_holder_dob',
        'ac_holder_state',
        'ac_holder_city',
        'ac_addr_line_1',
        'ac_addr_postal_code',
        'ac_holder_ssn',
        'ac_holder_bank_ac',
        'currency',
        'ac_holder_routing',
        'is_completed',
        'is_active'
    ];
}
