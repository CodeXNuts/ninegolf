<div class="tab-pane fade flexing profTabs" id="tab3" role="tabpanel" aria-labelledby="home-tab">

    <div class="choose  align-items-center">
        <h2>All listings</h2>
        <form>
            <input type="text" placeholder="Search.." class="search1" name="search">

        </form>
        <ul class="views">
            <li><a href="{{ route('product.create') }}"><img src="{{ asset('user/images/plus.svg') }}"> Create
                    Listing</a></li>
            <li> <a href="javascript:void(0)" data-view="list" class="viewType"><i class="fas fa-list-ul"></i></a></li>
            <li> <a href="javascript:void(0)" data-view="grid" class="viewType"><i class="fas fa-th-large"></i></a></li>

        </ul>

    </div>
    <div class="row gridbox prodMainBox">

        @if (!empty($products) && count($products) > 0)

            @foreach ($products as $eachProduct)
                @if (!empty($eachProduct->type) && $eachProduct->type == 'set')
                    <div class="listbox ">
                        @if (!empty($eachProduct->is_active) && $eachProduct->is_active == true)
                            <img src="{{ !empty($eachProduct->clubLists[0]->clubImages[0]->image_path) ? URL('/' . $eachProduct->clubLists[0]->clubImages[0]->image_path) : '' }}"
                                alt="">
                        @else
                            <img src="{{ !empty($eachProduct->clubLists[0]->clubImages[0]->image_path) ? URL('/' . $eachProduct->clubLists[0]->clubImages[0]->image_path) : '' }}"
                                alt="" style="opacity: 0.4">

                            </span>
                        @endif

                        <div class="listbox-dtl">
                            <h2>{{ $eachProduct->set_name ?? null }} - SET </h2>
                            <h3>{{ !empty($eachProduct->set_price_unit) ? ($eachProduct->set_price_unit == 'usd' ? 'USD$ ' : ($eachProduct->set_price_unit == 'cad' ? 'CA$ ' : '')) : '' }}{{ !empty($eachProduct->set_price)?number_format($eachProduct->set_price,2):'0.00' }}<span>
                                    / Day</span></h3>
                            <p>In stock • Listed on
                                {{ !empty($eachProduct->created_at) ? $eachProduct->created_at->toFormattedDateString() : '' }}
                            </p>
                            <p>Listed • 0 view</p>
                            <ul class="actionSec">
                                @if (!empty($eachProduct->is_active) && $eachProduct->is_active == true)
                                <li><a href="#" class="btn-in"><img
                                            src="{{ asset('user/images/rightt.svg') }}">In Stock</a></li>
                                <li><a href="javascript:void(0);"><img
                                            src="{{ asset('user/images/edit.svg') }}">Edit</a></li>

                                <li><a href="javascript:void(0);" class="shareBtn"><img
                                            src="{{ asset('user/images/sharee.svg') }}">Share</a></li>
                                <div class="shareUI" style="display: none">{!! $eachProduct->share_btn !!}</div>
                            @else
                                <span class="badge badge-warning" style="background-color: yellowgreen">Pending for
                                    approval</span>
                            @endif

                            </ul>

                        </div>
                    </div>
                @elseif (!empty($eachProduct->type) && $eachProduct->type == 'individual')
                    <div class="listbox ">

                        @if (!empty($eachProduct->is_active) && $eachProduct->is_active == true)
                            <img src="{{ !empty($eachProduct->clubLists[0]->clubImages[0]->image_path) ? URL('/' . $eachProduct->clubLists[0]->clubImages[0]->image_path) : '' }}"
                                alt="">
                        @else
                            <img src="{{ !empty($eachProduct->clubLists[0]->clubImages[0]->image_path) ? URL('/' . $eachProduct->clubLists[0]->clubImages[0]->image_path) : '' }}"
                                alt="" style="opacity: 0.4">

                            </span>
                        @endif
                        <div class="listbox-dtl">
                            <h2>{{ $eachProduct->clubLists[0]->name ?? null }} </h2>
                            <h3>{{ !empty($eachProduct->clubLists[0]->priceUnit) ? ($eachProduct->clubLists[0]->priceUnit == 'usd' ? 'USD$ ' : ($eachProduct->clubLists[0]->priceUnit == 'cad' ? 'CA$ ' : '')) : '' }}{{ !empty($eachProduct->clubLists[0]->price) ? number_format($eachProduct->clubLists[0]->price, 2) : '0.00' }}<span>
                                    / Day</span></h3>
                            <p>In stock • Listed on
                                {{ !empty($eachProduct->created_at) ? $eachProduct->created_at->toFormattedDateString() : '' }}
                            </p>
                            <p>Listed • 0 view</p>
                            <ul class="actionSec">

                                @if (!empty($eachProduct->is_active) && $eachProduct->is_active == true)
                                    <li><a href="#" class="btn-in"><img
                                                src="{{ asset('user/images/rightt.svg') }}">In Stock</a></li>
                                    <li><a href="javascript:void(0);"><img
                                                src="{{ asset('user/images/edit.svg') }}">Edit</a></li>

                                    <li><a href="javascript:void(0);" class="shareBtn"><img
                                                src="{{ asset('user/images/sharee.svg') }}">Share</a></li>
                                    <div class="shareUI" style="display: none">{!! $eachProduct->share_btn !!}</div>
                                @else
                                    <span class="badge badge-warning" style="background-color: yellowgreen">Pending for
                                        approval</span>
                                @endif

                            </ul>

                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <p> You don't have any clubs listed yet.</p> <a href="{{ route('product.create') }}">Create one? </a>
        @endif

    </div>
</div>
