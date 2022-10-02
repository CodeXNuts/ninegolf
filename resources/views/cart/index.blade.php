<x-app-layout>
    <x-slot name="addOnCss">
        <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />

  <style>
    #payment-form .control-label {
        text-align: inherit !important;
        font-size: 16px;
    }
  </style>

    </x-slot>
    <div class="cart">
        <div class="container">
            <div class="row">
                <h2>Cart</h2>
                <div class="col-lg-8 col-md-8 cartItemSec">
                    @if (!empty($crtContents->cartItems) && count($crtContents->cartItems) > 0)
                        @php
                            $pickUpCharges = 0.0;
                            $subTotal = 0.0;
                            
                        @endphp
                        @foreach ($crtContents->cartItems as $item)
                            <div class="listbox cartItem" data-identifier="{{ $item->id ?? null }}"
                                data-targetURI="{{ route('cartItem.remove', ['cartItem' => $item->id]) }}">
                                <img src="{{ asset('user/images/drv.png') }}" alt="">
                                {{-- <img src="{{ URL('/'.$item->club->clubLists[0]->clubImages[0]->image_path) }}" alt=""> --}}

                                <div class="listbox-dtl">

                                    @if (!empty($item->club->type) && $item->club->type == 'set')
                                        <h2>{{ $item->club->set_name ?? null }} </h2>
                                        <h3>${{ $item->club->set_price ?? null }}<span> / Day</span></h3>
                                    @elseif (!empty($item->club->type) && $item->club->type == 'individual')
                                        <h2>{{ $item->club->clubLists[0]->name ?? null }} </h2>
                                        <h3>${{ $item->club->clubLists[0]->price ?? null }}<span> / Day</span>
                                        </h3>
                                    @endif

                                    <p>{{ $item->clubAddress->address ?? null }}</p>
                                    <p>{{ !empty($item->from_date) ? \Carbon\Carbon::parse($item->from_date)->toFormattedDateString() : '' }}
                                    </p>
                                    <p>{{ !empty($item->to_date) ? \Carbon\Carbon::parse($item->to_date)->toFormattedDateString() : '' }}
                                    </p>

                                </div>


                                <div class="listbox-dtl2 listbox-dtl">
                                    <h2>Total cost: </h2>
                                    @if (!empty($item->club->type) && $item->club->type == 'set')
                                        @php
                                            $subTotal = $subTotal + (floatval($item->club->set_price) * intval($item->days));
                                        @endphp
                                        <h3>${{ !empty($item->club->set_price) ? number_format(floatval($item->club->set_price) * intval($item->days), 2) : 0.0 }}
                                        </h3>
                                        <p>*${{ $item->club->set_price ?? 0.0 }} x {{ $item->days ?? 0 }}
                                            days</p>
                                    @elseif (!empty($item->club->type) && ($item->club->type == 'individual'))
                                        @php
                                            $subTotal = $subTotal + (floatval($item->club->clubLists[0]->price) * intval($item->days));
                                        @endphp
                                        <h3>${{ !empty($item->club->clubLists[0]->price) ? number_format(floatval($item->club->clubLists[0]->price) * intval($item->days), 2) : 0.0 }}
                                        </h3>
                                        <p>*${{ $item->club->clubLists[0]->price ?? 0.0 }} x
                                            {{ $item->days ?? 0 }} days</p>
                                    @endif

                                    <p>Pickup Charge:
                                        {{ !empty($item->clubAddress->price) ? ($item->clubAddress->price == 0 ? 'Free' : '$' . number_format($item->clubAddress->price, 2)) : 'Free' }}
                                    </p>
                                    @php
                                        $pickUpCharges = $pickUpCharges + (!empty($item->clubAddress->price) ? floatval($item->clubAddress->price) : 0.0);
                                    @endphp

                                    <ul>
                                        <li><a href="javascript:void(0)" class="removeItem">Remove from cart</a>
                                        </li>


                                    </ul>


                                </div>




                            </div>
                        @endforeach
                    @else
                        <img src='/user/images/empty-cart.gif' style='width:110px;height:110px'>
                        <p>You don't have any items in your cart</p>
                    @endif
                </div>
                <div class=" col-lg-3 col-md-3 ms-auto">
                    <div class="pricesec">
                        <h2>Total cost</h2>
                        <table>
                            <tbody class="priceSecTbl">

                                @foreach ($priceBox as $price)
                                    <tr>
                                        <td>{{ $price['name'] ?? 'N.A' }}</td>
                                        <td>${{ $price['cost'] ?? 'N.A' }}</td>
                                    </tr>
                                @endforeach

                                @if (!empty($crtContents->cartItems) && count($crtContents->cartItems) > 0)
                                    <tr style="border-top: 1px solid #D1D1D1;">
                                        <td>Sub-Total </td>
                                        <td>${{ number_format($subTotal, 2) }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #D1D1D1;">
                                        <td>Pickup Charges </td>
                                        <td>${{ number_format($pickUpCharges, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total </td>
                                        @php
                                            $total = number_format($subTotal + $pickUpCharges, 2);
                                        @endphp
                                        <td>${{ $total ?? 0 }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <a href="javascript:void(0)" data-target-auth="{{ route('order.checkAuth') }}" data-target="{{ auth()->check() ? route('order.create') : '' }}" id="checkout"
                            class="epf">Checkout</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="login-form-template" class="contact" style="overflow: hidden;display:none;min-height: auto">
        <form id="checkout-login-form" data-target="{{ route('login') }}">
            <div class="form-group">
                <label>Email</label>
                <div class="row">
                    <div class="col-md-12">
        
                        <input type="email" name="email" id="checkOutEmail" value="" placeholder="Enter Login Email">
        
                    </div>
                    <div class="col-md-12">
                        <label>Password</label>
                        <input type="password" name="password" id="checkOutPass" placeholder="Enter Password">
                    </div>

                    <div class="col-md-12 justify-end">
                        <a href="{{ route('register') }}">New here? Register now</a>
                    </div>
        
                </div>
                
            </div>
        </form>
    </div>
    @auth
    <x-payment.stripe-payment :amount="$total??0"/>
    @endauth
    <x-slot name="addOnJs">
        @auth
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript" src="common/js/stripe.js"></script>
        @endauth
        <script src="{{ asset('user/js/pages/checkout.js') }}"></script>
        <script src="{{ asset('user/js/pages/checkout-order.js') }}"></script>
        
    </x-slot>
</x-app-layout>
