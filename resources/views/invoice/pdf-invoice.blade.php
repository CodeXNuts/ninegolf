<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Two Nine Golf</title>

    <style>
        body {
            margin-top: 20px;
            background: #eee;
        }

        .invoice {
            background: #fff;
            padding: 20px
        }

        .invoice-company {
            font-size: 20px
        }

        .invoice-header {
            margin: 0 -20px;
            background: #f0f3f4;
            padding: 20px
        }

        .invoice-from,
        .invoice-to {
            padding-right: 20px
        }

        .invoice-date .date,
        .invoice-from strong,
        .invoice-to strong {
            font-size: 16px;
            font-weight: 600
        }

        .invoice-date {
            text-align: right;
            padding-left: 20px
        }

        .invoice-price {
            background: #f0f3f4;
            width: 100%
        }

        .invoice-price .invoice-price-left,
        .invoice-price .invoice-price-right {
            padding: 20px;
            font-size: 20px;
            font-weight: 600;
            width: 75%;
            position: relative;
            vertical-align: middle
        }

        .invoice-price .invoice-price-right {
            width: 25%;
            background: #2d353c;
            color: #fff;
            font-size: 28px;
            text-align: right;
            vertical-align: bottom;
            font-weight: 300
        }

        .invoice-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 10px
        }

        .invoice-note {
            color: #999;
            margin-top: 80px;
            font-size: 85%
        }

        .invoice>div:not(.invoice-footer) {
            margin-bottom: 20px
        }

        .btn.btn-white,
        .btn.btn-white.disabled,
        .btn.btn-white.disabled:focus,
        .btn.btn-white.disabled:hover,
        .btn.btn-white[disabled],
        .btn.btn-white[disabled]:focus,
        .btn.btn-white[disabled]:hover {
            color: #2d353c;
            background: #fff;
            border-color: #d9dfe3;
        }

        .pricelist {
            padding: 10px;
            border-bottom: 1px solid #000;
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top: 12px">

        <div class="col-md-12">
            <div class="invoice">
                <!-- begin invoice-company -->

                <div class="invoice-content">

                    <div class="table-responsive">
                        <table width="100%" class="table table-invoice" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="https://previewforclient.com/ninegolf/images/logo.png"
                                            style="padding:10px " alt="">
                                    </td>
                                    <td colspan="3">Two Nine Golfs, Inc</td>
                                </tr>
                                <tr style="background: #f0f3f4;">
                                    <td>
                                        <div class="invoice-to">
                                            <small>To</small>
                                            <address class="m-t-5 m-b-5">
                                                <strong class="text-inverse">

                                                    {{ $orderData['user']['fname'] . ' ' . $orderData['user']['fname'] }}</strong><br>
                                                {{ $orderData['user']['location'] ?? '' }}<br>
                                                Email: {{ $orderData['user']['email'] ?? '' }} <br>
                                                Phone: {{ $orderData['user']['phone'] ?? '' }}<br>

                                            </address>
                                        </div>
                                    </td>

                                    <td colspan="3">
                                        <div class="invoice-date">
                                            <small>Invoice /
                                                {{ !empty($orderData['order_month']) ? Str::upper($orderData['order_month']) : '' }}
                                                period</small>
                                            <div class="date text-inverse m-t-5">
                                                {{ !empty($orderData['formatted_created_at']) ? $orderData['formatted_created_at'] : '' }}
                                            </div>
                                            <div class="invoice-detail">
                                                {{ $orderData['order_serial'] ?? '' }}<br>
                                                <p style="margin-bottom: 2px">Order Status: <b>{{ !empty($orderData['order_state']) ? Str::title($orderData['order_state']) : 'Pending' }}</b></p>
                                                <p style="margin-bottom: 2px">Payment Status: <b>{{ !empty($orderData['orderTransaction']['transaction_status']) ? Str::title($orderData['orderTransaction']['transaction_status']) : 'Pending' }}</b></p>
                                                <p style="margin-bottom: 2px">Transaction ID: <b>{{ $orderData['orderTransaction']['transaction_id'] ?? 'N.A' }}</b></p>

                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <tr
                                    style=" 
                                color: #000;font-size:12px;text-transform:capitalize; font-weight:400; border-bottom: 1px solid #000;
                               ">
                                    <th>Club Info</th>
                                    <th class="text-center" width="10%">PRICE</th>
                                    <th class="text-center" width="10%">DAYS</th>
                                    <th class="text-right" width="20%">RENT TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $pickUpCharges = 0.0;
                                    $subTotal = 0.0;
                                    
                                @endphp
                                @foreach ($orderData['order_details'] as $eachItem)
                                    <tr class="pricelist">
                                        <td>
                                          
                                            @if (!empty($eachItem['club']['type']) && $eachItem['club']['type'] == 'set')
                                                <span style="font-size: 20px;"
                                                    class="text-inverse">{{ !empty($eachItem['club']['set_name']) ? Str::title($eachItem['club']['set_name']) : '--' }}</span><br>
                                            @elseif (!empty($eachItem['club']['type']) && $eachItem['club']['type'] == 'individual')
                                                <span class="text-inverse"
                                                    style="font-size: 20px;">{{ !empty($eachItem['club']['club_lists'][0]['name']) ? Str::title($eachItem['club']['club_lists'][0]['name']) : '--' }}</span><br>
                                            @endif
                                            <small>From:
                                                {{ !empty($eachItem['formatted_from']) ? $eachItem['formatted_from'] : '' }}
                                                <br>
                                                To:
                                                {{ !empty($eachItem['formatted_to']) ? $eachItem['formatted_to'] : '' }}
                                            </small>
                                            @php
                                                $pickUpCharges = $pickUpCharges + (!empty($eachItem['club_address']['price']) ? floatval($eachItem['club_address']['price']) : 0);
                                            @endphp
                                            <address>
                                                Pick Up/ Drop Off:
                                                {{ !empty($eachItem['club_address']['address']) ? $eachItem['club_address']['address'] : '' }}
                                            </address>

                                        </td>
                                        @php
                                            $subTotal = $subTotal + ((!empty($eachItem['club_amount']) && !empty($eachItem['days'])) ? floatval($eachItem['club_amount']) * intval($eachItem['days']) : 0.0);
                                        @endphp
                                        <td style="text-align:left">
                                            ${{ !empty($eachItem['club_amount']) ? number_format(floatval($eachItem['club_amount']), 2) : 0.0 }}
                                        </td>
                                        <td style="text-align:left">
                                            {{ !empty($eachItem['days']) ? $eachItem['days'] . Str::plural('day', intval($eachItem['days'])) : '' }}
                                        </td>
                                        <td style="text-align:left">
                                            ${{ !empty($eachItem['club_amount']) && !empty($eachItem['days']) ? number_format(floatval($eachItem['club_amount']) * intval($eachItem['days']), 2) : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3 "> <small>SUBTOTAL</small>
                                        <span class="text-inverse ">${{ number_format($subTotal, 2) }}</span>
                                        <i class="fa fa-plus text-muted " style="margin:4px; "></i>

                                        <small>PICKUP/DROP OFF FEE</small>
                                        <span class="text-inverse ">${{ number_format($pickUpCharges, 2) }}</span>
                                    </td>
                                    <td style=" background: #000; color: #fff; ">
                                        <div class="invoice-price-right ">
                                            <small>TOTAL</small> <span
                                                class="f-w-600 ">${{ number_format($subTotal + $pickUpCharges, 2) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="invoice-note">
                    * Make all cheques payable to [Your Company Name]<br>
                    * Payment is due within 30 days<br>
                    * If you have any questions concerning this invoice, contact [Name, Phone Number, Email]
                </div>
                <!-- end invoice-note -->
                <!-- begin invoice-footer -->
                <div class="invoice-footer">
                    <p class="text-center m-b-5 f-w-600">
                        THANK YOU FOR YOUR BUSINESS
                    </p>
                    <p class="text-center">
                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> matiasgallipoli.com</span>
                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> T:016-18192302</span>
                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> rtiemps@gmail.com</span>
                    </p>
                </div>
                <!-- end invoice-footer -->
            </div>
        </div>
    </div>

</body>

</html>
