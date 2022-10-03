<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetails;
use App\Models\OrderTransaction;
use App\Models\PaymentGateway\Stripe as PaymentGatewayStripe;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stripe;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Stripe\Stripe as StripeStripe;

class OrderController extends Controller
{
    private $orderState = [
        'pending',
        'completed',
        'refunded'
    ];

    private $orderTxnType = [
        'payment',
        'void/refunded'
    ];

    private $orderTxnStatus = [
        'fail',
        'success'
    ];

    function __construct()
    {
        $this->middleware('auth');
    }

    public function checkAuth()
    {
        return ['res' => auth()->check()];
    }

    public function create(Request $request)
    {


        try {
            $res = [
                'key' => 'fail',
                'msg' => ''
            ];
            $authID = auth()->id();
            if (!empty($authID)) {
                $cart = (new CartController())->getCart();

                if (!empty($cart) && (count($cart) > 0) && !empty($cart['crtContents']->cartItems)) {
                    $orderTblPayload = $this->prepareOrderTblData($cart);

                    if (!empty($orderTblPayload)) {
                        $createdOrder = $this->createOrderTblData($orderTblPayload);

                        if (!empty($createdOrder->id)) {
                            $orderDetailsTblPayload = $this->prepareOrderDetailsTblData($cart, $createdOrder);

                            if (!empty($orderDetailsTblPayload)) {

                                $isOrderDetailsInserted = $this->createOrderDetailsTblData($orderDetailsTblPayload);

                                if ($isOrderDetailsInserted) {
                                    if (!empty($request->stripeToken)) {
                                        $gatewayPayload = $this->preparePaymentStripeGatewayPayload($createdOrder, $request->stripeToken);

                                        if (!empty($gatewayPayload)) {
                                            $payment = (new PaymentController())->makePayment($gatewayPayload, 'STRIPE_PAY');

                                            $txnData = null;
                                            if ((!empty($payment->id)) && ($payment->captured == true) && (!empty($payment->paid))) {
                                                $orderState = 1;
                                                $txnData = [
                                                    'order_id' => $createdOrder->id,
                                                    'amount' => floatval($gatewayPayload['amount']) / 100,
                                                    'gateWayPayload' => $gatewayPayload ?? [],
                                                    'gatewayResponse' => $payment,
                                                    'txnID' => $payment->id ?? null,
                                                    'txnType' => 1,
                                                    'txnStatus' => 1
                                                ];

                                                $res = [
                                                    'key' => 'success',
                                                    'msg' => 'Order has been placed successfully. Successful payment',
                                                    'code' => 200,
                                                    'targetURI' => route('user.order.view', ['order' => $createdOrder->id])
                                                ];
                                            } else {
                                                $orderState = 0;

                                                $txnData = [
                                                    'order_id' => $createdOrder->id,
                                                    'amount' => floatval($gatewayPayload['amount']) / 100,
                                                    'gateWayPayload' => $gatewayPayload ?? [],
                                                    'gatewayResponse' => $payment,
                                                    'txnID' => null,
                                                    'txnType' => 1,
                                                    'txnStatus' => 0
                                                ];

                                                $res = [
                                                    'key' => 'success',
                                                    'msg' => 'Order is pending. Un-successful payment',
                                                    'code' => 200,
                                                    'targetURI' => route('user.order.view', ['order' => $createdOrder->id])
                                                ];
                                            }

                                            $orderTxnTblPayload = $this->preapareOrderTxnTblData($txnData);

                                            if (!empty($orderTxnTblPayload)) {
                                                $orderTxnTbldata = $this->createOrderTxnTblData($orderTxnTblPayload);
                                            }

                                            //update the order $table
                                            $createdOrder->order_state = $orderState;
                                            $createdOrder->save();
                                        } else {
                                            $res = [
                                                'key' => 'fail',
                                                'msg' => 'Payment failed, try again',
                                                'code' => 200,
                                                'targetURI' => route('user.order.view', ['order' => $createdOrder->id])
                                            ];
                                        }
                                    } else {
                                        $res = [
                                            'key' => 'fail',
                                            'msg' => 'Payment failed, try again',
                                            'code' => 200,
                                            'targetURI' => route('user.order.view', ['order' => $createdOrder->id])
                                        ];
                                    }
                                } else {
                                    $res = [
                                        'key' => 'fail',
                                        'msg' => 'Order has not been placed, try again',
                                        'code' => 500
                                    ];
                                }
                            }
                        } else {
                            $res = [
                                'key' => 'fail',
                                'msg' => 'Order has not been placed, try again',
                                'code' => 500
                            ];
                        }
                    }
                } else {
                    $res = [
                        'key' => 'fail',
                        'msg' => 'You do not have any club in your cart',
                        'code' => 500
                    ];
                }
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'You are not logged in.',
                    'code' => 500
                ];
            }
        } catch (Exception $e) {

            $res = [
                'key' => 'fail',
                'msg' => $e->getMessage(),
                'code' => 500
            ];
        }

        return $res;
    }

    public function view(Order $order)
    {
        $this->authorize('view', $order);

        $orderData = Order::with(['user', 'orderDetails', 'orderDetails.club', 'orderDetails.club.user', 'orderDetails.clubAddress', 'orderTransaction'])->find($order->id);

        $orderData->order_state = $this->orderState[$orderData->order_state] ?? $this->orderState[0];
        if (!empty($orderData->orderTransaction->transaction_type)) {
            $orderData->orderTransaction->transaction_type = $this->orderTxnType[intval($orderData->orderTransaction->transaction_type) - 1] ?? '';
            $orderData->orderTransaction->transaction_status = $this->orderTxnStatus[$orderData->orderTransaction->transaction_status] ?? '';
        }

        if (!empty($orderData)) {
            return view('invoice.order-invoice', ['orderData' => $orderData]);
        } else {
            throw new ModelNotFoundException();
        }
    }

    public function generatePDF(Order $order)
    {
        $this->authorize('view', $order);

        $orderData = Order::with(['user', 'orderDetails', 'orderDetails.club', 'orderDetails.club.user', 'orderDetails.clubAddress'])->find($order->id);
        $orderData->order_state = $this->orderState[$orderData->order_state] ?? $this->orderState[0];
        if (!empty($orderData->orderTransaction->transaction_type)) {
            $orderData->orderTransaction->transaction_type = $this->orderTxnType[intval($orderData->orderTransaction->transaction_type) - 1] ?? '';
            $orderData->orderTransaction->transaction_status = $this->orderTxnStatus[$orderData->orderTransaction->transaction_status] ?? '';
        }

        if (!empty($orderData)) {

            $pdf = PDF::loadView('invoice.pdf-invoice', ['orderData' => $orderData->toArray()])->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);
            return $pdf->download($orderData->order_serial . '_' . $orderData->created_at->toFormattedDateString() . '.pdf');
        } else {
            throw new ModelNotFoundException();
        }
    }
    public static function getLatestOrder()
    {
        return Order::orderBy('created_at', 'DESC')->first();
    }

    private function generateOrderNr($latestOrderId)
    {
        if ($latestOrderId !== null && is_numeric($latestOrderId)) {
            return '#OD' . str_pad($latestOrderId + 1, 8, "0", STR_PAD_LEFT);
        }
    }


    public function prepareOrderTblData($data)
    {
        if (!empty($data) && (count($data) > 0)) {
            $order = new Order();

            $latestOrder = $this->getLatestOrder();

            $latestOrderId = empty($latestOrder) ? 0 : $latestOrder->id;

            $orderSerial = $this->generateOrderNr($latestOrderId);

            return [
                'orderSerial' => $orderSerial,
                'userId' => auth()->id(),
                'amount' => $this->getOrderTotalAmountFromCartData($data),
                'status' => 'not pickedup yet',
                'orderState' => 0
            ];
        }
    }

    public function getOrderTotalAmountFromCartData($data)
    {

        if ((!empty($data)) && (!empty($data)) && (count($data) > 0)) {
            $totalItemPrice = 0;

            if (!empty($data['priceBox']) && (count($data['priceBox']) > 0)) {
                foreach ($data['priceBox'] as $price) {
                    $totalItemPrice = $totalItemPrice + $this->convertToFloatvalue($price['cost']);
                }
            }

            if (!empty($data['crtContents']->cartItems) && (count($data['crtContents']->cartItems) > 0)) {
                foreach ($data['crtContents']->cartItems as $items) {

                    $totalItemPrice = $totalItemPrice + floatval($items->clubAddress->price);
                }
            }

            return $totalItemPrice;
        }
    }

    private function createOrderTblData($data)
    {
        try {


            $createdOrder = Order::create([
                'order_serial' => $data['orderSerial'] ?? null,
                'user_id' => $data['userId'] ?? null,
                'amount' => $data['amount'] ?? null,
                'status' => $data['status'] ?? null,
                'order_state' => $data['orderState'] ?? null
            ]);

            return $createdOrder;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function prepareOrderDetailsTblData($data, $orderDetails)
    {
        $payload = [];

        if (!empty($data['crtContents']->cartItems) && (count($data['crtContents']->cartItems) > 0)) {
            foreach ($data['crtContents']->cartItems as $items) {

                array_push($payload, [
                    'order_id' => $orderDetails->id ?? null,
                    'club_id' => $items->club_id,
                    'club_amount' => (!empty($items->club->type) && ($items->club->type == 'set')) ? floatval($items->club->set_price) : (!empty($items->club->type) && ($items->club->type == 'individual') ? floatval($items->club->clubLists[0]->price) : null),
                    'from_date' => $items->from_date ?? null,
                    'from_time' => $items->from_time ?? null,
                    'to_date' => $items->to_date ?? null,
                    'to_time' => $items->to_time ?? null,
                    'days' => $items->days ?? 0,
                    'club_address_id' => $items->club_address_id ?? null,
                    'club_address_amount' => !empty($items->clubAddress->price) ? floatval($items->clubAddress->price) : 0.00
                ]);
            }
        }


        return $payload;
    }

    public function createOrderDetailsTblData($data)
    {
        $success = true;
        foreach ($data as $eachPayload) {

            $createdOrderDetails = OrderDetail::create([
                'order_id' => $eachPayload['order_id'] ?? null,
                'club_id' => $eachPayload['club_id'] ?? null,
                'club_amount' => $eachPayload['club_amount'] ?? 0.00,
                'from_date' => $eachPayload['from_date'] ?? null,
                'from_time' => $eachPayload['from_time'] ?? null,
                'to_date' => $eachPayload['to_date'] ?? null,
                'to_time' => $eachPayload['to_time'] ?? null,
                'days' => $eachPayload['days'] ?? 0,
                'club_address_id' => $eachPayload['club_address_id'] ?? null,
                'club_address_amount' => $eachPayload['club_address_amount'] ?? 0.00
            ]);

            if (empty($createdOrderDetails)) {
                $success == false;

                break;
            }
        }

        return $success;
    }

    public function preparePaymentStripeGatewayPayload($data, $token)
    {
        if (!empty($data->order_serial)  && ($data->amount) && (!empty($token))) {
            return [
                "amount" => floatval($data->amount) * 100,
                "currency" => "usd",
                "source" => $token,
                "description" => "Payment from ninegolf for order: " . $data->order_serial
            ];
        }
    }

    private function preapareOrderTxnTblData($data)
    {
        return [
            'order_id' => $data['order_id'] ?? null,
            'payment_gateway_id' => 1,
            'amount' => $data['amount'] ?? 0,
            'transaction_payload' => json_encode([
                'payload' => !empty($data['gateWayPayload']) ? json_encode($data['gateWayPayload']) : [],
                'response' => !empty($data['gatewayResponse']) ? json_encode($data['gatewayResponse']) : []
            ]),
            'transaction_id' => $data['txnID'] ?? null,
            'transaction_type' => $data['txnType'] ?? 1,
            'transaction_status' => $data['txnStatus'] ?? 1
        ];
    }

    public function createOrderTxnTblData($data)
    {
        try {
            $isOrderTxnInserted = OrderTransaction::create([
                'order_id' => $data['order_id'] ?? null,
                'payment_gateway_id' => $data['payment_gateway_id'],
                'amount' => $data['amount'] ?? 0,
                'transaction_id' => $data['transaction_id'] ?? null,
                'transaction_payload' => $data['transaction_payload'] ?? null,
                'transaction_type' => $data['transaction_type'] ?? 1,
                'transaction_status' => $data['transaction_status'] ?? 0
            ]);

            return $isOrderTxnInserted;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function convertToFloatvalue($val)
    {
        $val = str_replace(",", ".", $val);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);
        return floatval($val);
    }
}
