
<div class="container" style="margin-top: 12px">
    <div class="col-md-12">
        <div class="invoice">
            <!-- begin invoice-company -->
            <div class="invoice-company text-inverse f-w-600">
                <span class="pull-right hidden-print">
                    <a href="{{ route('user.order.invoice.download',['order'=>$orderData->id]) }}" class="btn btn-sm btn-white m-b-10 p-l-5"><i
                            class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Download PDF</a>
                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i
                            class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
                </span>
                Two Nine Golfs, Inc
            </div>
            <!-- end invoice-company -->
            <!-- begin invoice-header -->
            <div class="invoice-header">
                {{-- <div class="invoice-from">
           <small>from</small>
           <address class="m-t-5 m-b-5">
              <strong class="text-inverse">Twitter, Inc.</strong><br>
              Street Address<br>
              City, Zip Code<br>
              Phone: (123) 456-7890<br>
              Fax: (123) 456-7890
           </address>
        </div> --}}
                <div class="invoice-to">
                    <small>To</small>
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">
                            <img src="{{ !empty($orderData->user->avatar) ? URL('/' . $orderData->user->avatar) : '' }}"
                                style="height: 30px;width:30px" class="rounded-circle" />
                            {{ $orderData->user->fname . ' ' . $orderData->user->lname }}</strong><br>
                        {{ $orderData->user->location ?? '' }}<br>
                        Email: {{ $orderData->user->email ?? '' }} <br>
                        Phone: {{ $orderData->user->phone ?? '' }}<br>

                    </address>
                </div>
                <div class="invoice-date">
                    <small>Invoice / {{ !empty($orderData->created_at) ? $orderData->created_at->format('M') : '' }}
                        period</small>
                    <div class="date text-inverse m-t-5">
                        {{ !empty($orderData->created_at) ? $orderData->created_at->toFormattedDateString() : '' }}
                    </div>
                    <div class="invoice-detail">
                        {{ $orderData->order_serial ?? '' }}<br>
                        <p style="margin-bottom: 2px">Order Status: <b>{{ !empty($orderData->order_state) ? Str::title($orderData->order_state) : 'Pending' }}</b></p>
                        <p style="margin-bottom: 2px">Payment Status: <b>{{ !empty($orderData->orderTransaction->transaction_status) ? Str::title($orderData->orderTransaction->transaction_status) : 'Pending' }}</b></p>
                        <p style="margin-bottom: 2px">Transaction ID: <b>{{ $orderData->orderTransaction->transaction_id ?? 'N.A' }}</b></p>
                        
                    </div>
                </div>
            </div>
            <!-- end invoice-header -->
            <!-- begin invoice-content -->
            <div class="invoice-content">
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table class="table table-invoice">
                        <thead>
                            <tr>
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
                            @foreach ($orderData->orderDetails as $eachItem)
                                <tr>
                                    <td>
                                        @if (!empty($eachItem->club->type) && $eachItem->club->type == 'set')
                                            <span
                                                class="text-inverse">{{ !empty($eachItem->club->set_name) ? Str::title($eachItem->club->set_name) : '' }}</span><br>
                                        @elseif (!empty($eachItem->club->type) && $eachItem->club->type == 'individual')
                                            <span
                                                class="text-inverse">{{ !empty($eachItem->club->clubLists[0]->name) ? Str::title($eachItem->club->clubLists[0]->name) : '' }}</span><br>
                                        @endif
                                        <small>From:
                                            {{ !empty($eachItem->from_date) && !empty($eachItem->from_time) ? \Carbon\Carbon::parse($eachItem->from_date . ' ' . $eachItem->from_time)->toFormattedDateString() : '' }}
                                            <br>
                                            To:
                                            {{ !empty($eachItem->to_date) && !empty($eachItem->to_time) ? \Carbon\Carbon::parse($eachItem->to_date . ' ' . $eachItem->to_time)->toFormattedDateString() : '' }}
                                        </small>
                                        @php
                                            $pickUpCharges = $pickUpCharges + (!empty($eachItem->clubAddress->price) ? floatval($eachItem->clubAddress->price) : 0)
                                        @endphp
                                        <address>
                                            {{ !empty($eachItem->clubAddress->address) ? $eachItem->clubAddress->address : '' }}
                                        </address>


                                    </td>
                                    @php
                                        $subTotal = $subTotal + ((!empty($eachItem->club_amount) && !empty($eachItem->days)) ? (floatval($eachItem->club_amount) * intval($eachItem->days)) : 0.00);
                                    @endphp
                                    <td class="text-center">
                                        ${{ !empty($eachItem->club_amount) ? number_format(floatval($eachItem->club_amount), 2) : 0.0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ !empty($eachItem->days) ? $eachItem->days . Str::plural('day', intval($eachItem->days)) : '' }}
                                    </td>
                                    <td class="text-right">
                                        ${{ !empty($eachItem->club_amount) && !empty($eachItem->days) ? number_format(floatval($eachItem->club_amount) * intval($eachItem->days), 2) : '' }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
                <!-- begin invoice-price -->
                <div class="invoice-price">
                    <div class="invoice-price-left">
                        <div class="invoice-price-row">
                            <div class="sub-price">
                                <small>SUBTOTAL</small>
                                <span class="text-inverse">${{ number_format($subTotal,2) }}</span>
                            </div>
                            <div class="sub-price">
                                <i class="fa fa-plus text-muted"></i>
                            </div>
                            <div class="sub-price">
                                <small>PICKUP/DROP OFF FEE </small>
                                <span class="text-inverse">${{ number_format($pickUpCharges,2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-price-right">
                        <small>TOTAL</small> <span class="f-w-600">${{ number_format(($subTotal +  $pickUpCharges),2) }}</span>
                    </div>
                </div>
                <!-- end invoice-price -->
            </div>
            <!-- end invoice-content -->
            <!-- begin invoice-note -->
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
