<?php

namespace App\Listeners;

use App\Events\OrderPlacedPaymentSuccess;
use App\Http\Controllers\PaymentController;
use App\Models\MerchantPayout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PayoutMerchant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlacedPaymentSuccess  $event
     * @return void
     */
    public function handle(OrderPlacedPaymentSuccess $event)
    {
        if (!empty($event->payload)) {
            foreach ($event->payload as $payload) {


                try {
                    $res = (new PaymentController())->payoutToMerchant($payload);
                } catch (\Throwable $th) {
                    // dd($th->getMessage());
                } finally {
                    $tblPayload = $this->prepareMerchantPayoutTblData($payload, $res);
                    
                    if (!empty($tblPayload)) {
                        try {
                            MerchantPayout::create([
                                'transaction_id' => $tblPayload['transaction_id'],
                                'seller_id' => $tblPayload['seller_id'],
                                'user_id' => $tblPayload['user_id'],
                                'order_id' => $tblPayload['order_id'],
                                'order_detail_id' => $tblPayload['order_detail_id'],
                                'user_stripe_connected_account_id' => $tblPayload['user_stripe_connected_account_id'],
                                'payout_merchant_amount' => $tblPayload['payout_merchant_amount'],
                                'payout_admin_amount' => $tblPayload['payout_admin_amount'],
                                'transfer_group' => $tblPayload['transfer_group'],
                                'merchant_desc' => $tblPayload['merchant_desc'],
                                'admin_desc' => $tblPayload['admin_desc'],
                                'transaction_payload' => $tblPayload['transaction_payload'],
                                'transaction_status' => (isset($tblPayload['transaction_status']) && is_numeric($tblPayload['transaction_status'])) ? intval($tblPayload['transaction_status']) : 0
                            ]);
                        } catch (\Throwable $th) {
                            // dd($th->getMessage());
                            //throw $th;
                        }
                    }
                }
            }
        }
    }

    public function prepareMerchantPayoutTblData($payload, $res)
    {
        if (!empty($payload) && !empty($res)) {
            return [
                'transaction_id' => $res->id ?? null,
                'seller_id' => $payload['sellerId'],
                'user_id' => $payload['userId'],
                'order_id' => $payload['orderId'],
                'order_detail_id' => $payload['orderDetailsId'],
                'user_stripe_connected_account_id' => $payload['sellerConnectedAcId'],
                'payout_merchant_amount' => !empty($payload['amountPayable'] && is_numeric($payload['amountPayable'])) ? floatval($payload['amountPayable']) / 100 : 0.00,
                'payout_admin_amount' => !empty($payload['amountAdmin']) && is_numeric($payload['amountAdmin']) ? $payload['amountAdmin'] : 0.00,
                'transfer_group' => $payload['transfer_group'],
                'merchant_desc' => $payload['seller_description'],
                'admin_desc' => $payload['admin_description'],
                'transaction_payload' => json_encode([
                    'payload' => !empty($payload) ? json_encode($payload) : [],
                    'response' => !empty($res) ? json_encode($res) : []
                ]),
                'transaction_status' => (!empty($res->id)) ? 1 : 0

            ];
        }
    }
}
