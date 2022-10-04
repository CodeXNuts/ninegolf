<?php

namespace App\Models\PaymentGateway;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe as StripeSDK;


class Stripe extends Model
{
    private $thisKey;
    use HasFactory;

    function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->thisKey = env('STRIPE_SECRET');
    }

    public function pay($payload)
    {
        try {
            $hasError = $this->validatePayloadForPay($payload);

            if (!$hasError) {
                $res = StripeSDK\Charge::Create([
                    "amount" => floatval($payload['amount']),
                    "currency" => $payload['currency'] ?? null,
                    "source" => $payload['source'] ?? null,
                    "description" => $payload['description'] ?? null
                ]);

                return $res;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createConnectedAccount()
    {
        try {

            $stripeRes =  (new \Stripe\StripeClient($this->thisKey))->accounts->create(
                [
                    'country' => 'US',
                    'type' => 'custom',
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                    'tos_acceptance' => [
                        'date' => time(),
                        'ip' => request()->ip()
                    ]
                ]
            );

            return $stripeRes;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateConnectedAccount($payload)
    {
        
        try {
            
            $updatedInfo = (new \Stripe\StripeClient($this->thisKey))->accounts->update(
                $payload['stripeConnectedAcId'],
                [
                    'business_type' => 'individual',
                    'email' => $payload['email'] ?? '',
                    'company' => [
                        'address' => [
                            'city' => $payload['companyCity'] ?? '',
                            'country' => $payload['companyCountry'] ?? '',
                            'line1' => $payload['companyAddrLine1'] ?? '',
                            'line2' => $payload['companyAddrLine2'] ?? '',
                            'postal_code' => $payload['companyPostalCode'] ?? '',
                            'state' => $payload['companyState'] ?? ''
                        ]
                    ],
                    'business_profile' => [
                        'mcc' => 5046,
                        'name' => $payload['businessProfileName'] ?? '',
                        'product_description' => $payload['businessProfileDesc'] ?? '',
                    ],
                    'individual' => [
                        'dob' => [
                            'day' => $payload['dobDay'] ?? '',
                            'month' => $payload['dobMonth'] ?? '',
                            'year' => $payload['dobYear'] ?? ''
                        ],
                        'address' => [
                            'city' => $payload['acHolderCity'] ?? '',
                            'line1' => $payload['acAddrLine1'] ?? '',
                            'line2' => $payload['acAddrLine1'] ?? '',
                            'postal_code' => $payload['acAddrPostalCode'] ?? '',
                            'state' => $payload['acHolderState'] ?? '',
                        ],
                        'first_name' => auth()->user()->fname ?? '',
                        'last_name' => auth()->user()->lname ?? '',
                        'email' => auth()->user()->email ?? '',
                        'phone' => 14842634667 ?? '',
                        'ssn_last_4' => $payload['acHolderSSN'] ?? ''
                    ],
                    'bank_account' => [
                        'country' => 'us',
                        'currency' => $payload['acHolderCurrency'] ?? '',
                        'routing_number' => $payload['acHolderRouting'] ?? '',
                        'account_number' => $payload['acHolderBankAC'] ?? ''
                    ],
                    'tos_acceptance[date]' => strtotime('now'),
                    'tos_acceptance[ip]' => request()->ip()

                ]
            );

            return [
                'code' => 200,
                'data' => $updatedInfo
            ];
            return $updatedInfo;
        } catch (\Throwable $th) {
            return [
                'code' => 500,
                'data' => $th->getMessage()
            ];
        }
    }

    public function payout($payload)
    {
        return StripeSDK\Transfer::create([
            "amount" => floatval($payload['amountPayable']),
            "currency" => "usd",
            "destination" => $payload['sellerStripeConnnectedId'] ?? null,
            'description' => $payload['seller_description'] ?? 'N.A',
            'transfer_group' => $payload['transfer_group'] ?? 'N.A'
          ]);
    }

    public function viewConnectedAccount($connectedAcId)
    {
        try {

            $connectedAcDetails = (new \Stripe\StripeClient($this->thisKey))->accounts->retrieve($connectedAcId);
            
            return [
                'code' => 200,
                'data' => $connectedAcDetails
            ];
        } catch (\Throwable $th) {
            return [
                'code' => 500,
                'data' => $th->getMessage()
            ];
        }
    }
    private function validatePayloadForPay($data)
    {
        $hasError = false;
        if (empty($data['amount']) && !is_numeric($data['amount'])) {
            $hasError = true;
            return $hasError;
        }
        if (empty($data['currency'])) {
            $hasError = true;
            return $hasError;
        }
        if (empty($data['source'])) {
            $hasError = true;
            return $hasError;
        }
        if (empty($data['description'])) {
            $hasError = true;
            return $hasError;
        }
    }
    
}
