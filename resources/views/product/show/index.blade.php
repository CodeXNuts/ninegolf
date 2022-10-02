<x-app-layout>
    <x-slot name="addOnCss">
        <style>
            #map {
                width: 100%;
                max-width: 768px;
                max-height: 900px;
                height: 200px;
            }

            .individualclub .ecomtxt .ticketrent h4 {
                font-weight: 500;
                font-size: 24px;
                line-height: 29px;
                text-transform: capitalize;
                color: #1E1E1E;
                display: inline-block;
            }
        </style>
    </x-slot>
    <div class="individualclub">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div id="gallery" class="row">

                        <div id="thumbs" class="col-lg-2 col-md-2">

                            @if (!empty($club->clubLists) && count($club->clubLists) > 0)

                                @foreach ($club->clubLists as $eachClub)
                                    @foreach ($eachClub->clubImages as $eachImage)
                                        <img src="{{ URL('/' . $eachImage->image_path) }}" alt="1st image description" />
                                    @endforeach
                                @endforeach
                            @endif

                        </div>
                        <div id="panel" class="col-lg-10 col-md-10">
                            <img id="largeImage" src="" class="imgsize" />
                            <div class="wishlist" data-add-URI="{{ route('wishlist.manage') }}"
                                data-prod="{{ $club->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="_1l0elc" width="20" height="20"
                                    viewBox="0 0 20 16">
                                    <path
                                        d="M8.695 16.682C4.06 12.382 1 9.536 1 6.065 1 3.219 3.178 1 5.95 1c1.566 0 3.069.746 4.05 1.915C10.981 1.745 12.484 1 14.05 1 16.822 1 19 3.22 19 6.065c0 3.471-3.06 6.316-7.695 10.617L10 17.897l-1.305-1.215z"
                                        fill="{{ !empty($isWishListed) && $isWishListed == 'true' ? '#EB4949' : '#fff' }}"
                                        class="eX72wL" border="none" stroke="#EB4949"></path>
                                </svg>
                            </div>
                        </div>


                    </div>
                    <div class="ecommbutt">
                        <ul class="prodActionBtn">
                            @if (!empty($isInCart) && $isInCart == 'true')
                                <li><a href="{{ route('cart') }}" class="" style="background-color: yellowgreen"
                                        data-cart-URI="{{ route('cart.add') }}" data-prod="{{ $club->id }}">Go to
                                        Cart</a></li>
                            @else
                                <li><a href="javascript:void(0)" class="addToCart"
                                        data-cart-URI="{{ route('cart.add') }}" data-prod="{{ $club->id }}">Add to
                                        Cart</a></li>
                            @endif
                            <li><a href="javascript:void(0)" id="buy" data-cart-URI="{{ route('cart.add') }}"
                                    data-prod="{{ $club->id }}">book Now</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">



                    <div class="ecomtxt">

                        @if (!empty($club->type) && $club->type == 'set')
                            <div>
                                <h2>{{ !empty($club->clubLists[0]->name) ? Str::title($club->clubLists[0]->name) : '' }}
                                    <span>{{ !empty($club->clubRatings->count('user_id')) ? number_format(floatval($club->clubRatings->sum('rating') / $club->clubRatings->count('user_id')), 1) : 0 }}
                                        <img src="{{ asset('user/images/yellowstar.svg') }}" alt="">
                                        <img src="{{ asset('user/images/yellowstar.svg') }}" alt=""> (29
                                        ratings)</span>
                                </h2>

                                <h3>{{ $club->set_price_unit ?? '' }} {{ $club->set_price }} <span>/day</span></h3>
                                <h4>Set Information</h4>
                                <ul class="setinformation">
                                    <li><span>Gender</span>{{ !empty($club->gender) ? Str::title($club->gender) : '' }}
                                    </li>
                                    <li><span>Dexterity</span>{{ !empty($club->dexterity) ? Str::title($club->dexterity) : '' }}
                                    </li>
                                    <li><span>Time Required Prior to Rental</span>{{ $club->adv_time ?? 0 }} hours
                                    </li>

                                </ul>

                                <h4>Set Makeup</h4>
                                <ul class="makeup">
                                    @if (!empty($club->clubLists) && count($club->clubLists) > 0)
                                        @foreach ($club->clubLists as $eachClub)
                                            @if (!empty($eachClub->name) && is_numeric(substr($eachClub->name, 0, 1)))
                                                <li><span>{{ Str::upper(substr($eachClub->name, 0, 3)) }}</span></li>
                                            @else
                                                <li><span>{{ Str::upper(substr($eachClub->name, 0, 1)) }}</span></li>
                                            @endif
                                        @endforeach
                                    @endif

                                </ul>
                            </div>
                        @elseif (!empty($club->type) && $club->type == 'individual')
                            <div>
                                <h2>{{ !empty($club->clubLists[0]->name) ? Str::title($club->clubLists[0]->name) : '' }}
                                    @php
                                        $avgRating = !empty($club->clubRatings->count('user_id')) ? number_format(floatval($club->clubRatings->sum('rating') / $club->clubRatings->count('user_id')), 1) : 0;
                                    @endphp
                                    <span>{{ $avgRating ?? 0 }}

                                        @if (!empty($avgRating))
                                            @for ($i = 0; $i < intval($avgRating); $i++)
                                                <i class="fas fa-star"
                                                    style="cursor: pointer;color:rgb(252, 215, 3)"></i>
                                            @endfor
                                        @endif
                                        ({{ !empty($club->clubRatings) ? count($club->clubRatings) : 0 }}
                                        {{ Str::plural('rating', $club->clubRatings) }})
                                    </span>
                                </h2>

                                <h3>{{ $club->clubLists[0]->priceUnit ?? '' }} {{ $club->clubLists[0]->price }}
                                    <span>/day</span>
                                </h3>
                                <h4>Club Information</h4>
                                <ul class="setinformation">
                                    <li><span>Gender</span>{{ !empty($club->gender) ? Str::title($club->gender) : '' }}
                                    </li>
                                    <li><span>Dexterity</span>{{ !empty($club->dexterity) ? Str::title($club->dexterity) : '' }}
                                    </li>
                                    <li><span>Time Required Prior to Rental</span>{{ $club->adv_time ?? 0 }} hours
                                    </li>
                                </ul>
                            </div>
                        @endif

                        <form class="form-inline">
                            <input type="hidden" name="club" id="clubID" value="{{ $club->id ?? '' }}">
                            <input type="hidden" name="priorTime" id="priorTime" value="{{ $club->adv_time ?? '' }}">
                            <h2>Rental Start</h2>



                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-6 col-md-12">
                                        <div class="forminput">
                                            <label for="">Date</label>
                                            <input type="text" name="rentFromDate" id="rentFromDate"
                                                placeholder="Select Date">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-6 col-md-12">
                                        <div class="forminput">
                                            <label>Time</label>
                                            <div class="show-input">
                                                <input type="text" name="rentFromTime" id="rentFromTime"
                                                    class="individualTimepicker" placeholder="Select Time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <h2>Rental End</h2>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-6">
                                        <div class="forminput">
                                            <label for="">Date</label>
                                            <input type="text" name="rentToDate" id="rentToDate"
                                                placeholder="Select Date">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-6">
                                        <div class="forminput">
                                            <label>Time</label>
                                            <div class="show-input">
                                                <input type="text" name="rentToTime" id="rentToTime"
                                                    class="individualTimepicker" placeholder="Select Time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4>Pickup & Return location</h4>
                            <div class="col-lg-12 col-md-12">
                                <div class="forminput">
                                    <label>Location</label>
                                    <select name="location" id="selectedLoc">
                                        <option value="">Select Pick Up/Drop off location</option>
                                        @if (!empty($club->clubAddresses))
                                            @php
                                                $baseLoc = '';
                                                $otherLoc = '';
                                            @endphp
                                            @foreach ($club->clubAddresses as $eachAddress)
                                                @if (!empty($eachAddress->locType) && $eachAddress->locType == 'base')
                                                    @php
                                                        $baseLoc .=
                                                            '<option value="' .
                                                            $eachAddress->id .
                                                            '"
                                                        data-lat="' .
                                                            $eachAddress->lat .
                                                            '"
                                                        data-title="' .
                                                            $eachAddress->loc_name .
                                                            '"
                                                        data-lng="' .
                                                            $eachAddress->lng .
                                                            '" data-addr="' .
                                                            $eachAddress->address .
                                                            '">' .
                                                            ($eachAddress->loc_name ?? '') .
                                                            '</option>';
                                                    @endphp
                                                @elseif (!empty($eachAddress->locType) && $eachAddress->locType == 'other')
                                                    @php
                                                        $otherLoc .=
                                                            '<option value="' .
                                                            $eachAddress->id .
                                                            '"
                                                        data-lat="' .
                                                            $eachAddress->lat .
                                                            '"
                                                        data-title="' .
                                                            $eachAddress->loc_name .
                                                            '"
                                                        data-lng="' .
                                                            $eachAddress->lng .
                                                            '" data-addr="' .
                                                            $eachAddress->address .
                                                            '">' .
                                                            ($eachAddress->loc_name ?? '') .
                                                            '</option>';
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <optgroup label="Base Location">
                                                {!! $baseLoc ?? '' !!}
                                            </optgroup>
                                            <optgroup label="Other Location">
                                                {!! $otherLoc ?? '' !!}
                                            </optgroup>
                                        @endif
                                    </select>
                                </div>
                                <p id="selectedAddress"></p>
                            </div>


                        </form>
                        {{-- <h4>Pickup & Return location</h4>
                        <div class="pick">
                            <h3>Location</h3>
                            <p>3891 Ranchview Dr. Richardson, California 62639</p>
                        </div> --}}
                        {{-- <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d101717.4764660908!2d-119.38568526441414!3d37.18428562354719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb9fe5f285e3d%3A0x8b5109a227086f55!2sCalifornia%2C%20USA!5e0!3m2!1sen!2sin!4v1661164522198!5m2!1sen!2sin"
                            width="100%" height="203" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe> --}}

                        <div id="map"></div>

                        <div class="ticketrent">
                            <h3>Total rent cost</h3>
                            <h4 id="totalRentalPrice">$98 </h4>
                            <p style="display: inline-block;"><span id="rentalSpan">(07/26/2022 to 07/29/2022)</span>
                            </p>
                        </div>
                        <div class="customersec">
                            <h2>Lister Information</h2>
                            <div class="customer-img">
                                <img style="width: 100px;height:100px"
                                    src="{{ !empty($club->user->avatar) ? URL('/' . $club->user->avatar) : 'https://style.anu.edu.au/_anu/4/images/placeholders/person.png' }}"
                                    alt="">
                                <div class="customer-details">
                                    <h3>{{ $club->user->fname . ' ' . $club->user->lname }}</h3>
                                    <h5>Rating 4.5 10+ • rental delivered successfully </h5>
                                    <p>Message</p>
                                </div>
                            </div>
                        </div>

                        <x-product.product-review-sec :clubReviews="$clubReviews" :club="$club" />

                    </div>



                </div>
            </div>
        </div>
    </div>
    <x-slot name="addOnJs">
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD50ia6qUmMpfh67VL2pDH2agjayxPww9U">
        </script>
        <script src="{{ asset('common/js/wishlist.js') }}"></script>
        <script src="{{ asset('common/js/cart.js') }}"></script>
        <script src="{{ asset('user/js/pages/product-review.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {

                $("#rentFromDate").datepicker({
                    dateFormat: "mm/dd/yy",
                    duration: "fast",
                    minDate: new Date(),
                    onSelect: function(selected) {
                        var dt = new Date(selected);
                        dt.setDate(dt.getDate() + 1);
                        $("#rentToDate").datepicker("option", "minDate", selected);
                        renderCalculatedPrice();
                    }
                });
                $("#rentToDate").datepicker({
                    dateFormat: "mm/dd/yy",
                    duration: "fast",
                    onSelect: function(selected) {
                        // var dt = new Date(selected);
                        // dt.setDate(dt.getDate() - 1);
                        // $("#rentFromDate").datepicker("option", "maxDate", selected);
                        renderCalculatedPrice();
                    }
                });
            });

            window.initMap = initMap(36.778259, -119.417931);
        </script>
    </x-slot>
</x-app-layout>
