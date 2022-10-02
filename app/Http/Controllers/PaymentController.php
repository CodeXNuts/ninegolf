<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway\Stripe;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function makePayment($payload , $GATEWAY_DESCRIPTOR)
    {
        $res = [];

        if(!empty($payload) && !empty($GATEWAY_DESCRIPTOR))
        {
            switch ($GATEWAY_DESCRIPTOR) {
                case 'STRIPE_PAY':
                        $res = (new Stripe())->pay($payload);

                    break;
                
                default:
                    # code...
                    break;
            }
        }

        return $res;
    }
}
