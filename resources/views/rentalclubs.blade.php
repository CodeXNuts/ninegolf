<x-app-layout>
    <x-slot name="addOnCss"></x-slot>
    <div class="mainbanner">
        <img src="{{ asset('user/images/rent.png') }}" alt="">
        <div class="bantxt">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-10 m-auto">
                        <form class="form-inline">
                            <div class="col-lg-4 col-md-4">
                                <label for="">Where</label>
                                <input type="text" class="book" placeholder="City, club &amp; address etc.">
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="">From</label>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" id="datepicker" placeholder="Select Date">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
    
                                        <div class="show-input">
                                            <input type="text" name="time" placeholder="Select Time">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="">Untill</label>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" id="datepicker2" placeholder="Select Date">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
    
                                        <div class="show-input">
                                            <input type="text" name="time" placeholder="Select Time">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="search">
                                    <img src="{{ asset('user/images/Search.svg') }}">
                                </div>
                            </div>
                        </form>
    
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    
    
    
    <div class="howitwork">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="heading">
    
                        <h2>How It works </h2>
    
                    </div>
                </div>
    
    
    
                <div class="col-lg-4 col-md-4">
                    <div class="worksimg">
                        <img src="{{ asset('user/images/1.png') }}" alt="">
    
                        <div class="workstxt">
                            <h2>List your clubs</h2>
                            <p>Post pics that pop, pick an hourly price, and set your club rules.</p>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-4">
                    <div class="worksimg">
                        <img src="{{ asset('user/images/2.png') }}" alt="">
    
                        <div class="workstxt">
                            <h2>Accept bookings</h2>
                            <p>Check booking requests from swimmers in your community and approve at your discretion.</p>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-4">
                    <div class="worksimg">
                        <img src="{{ asset('user/images/3.png') }}" alt="">
    
                        <div class="workstxt">
                            <h2>Get paid!</h2>
                            <p>We ensure secure payments directly to your bank account 24 hours after a completed booking.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clubnear">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
    
                    <div class="rnt">
                        <h2>Clubs near you</h2>
                        <ul>
                            <li><a href="#"> <img src="{{ asset('user/images/sorts.svg') }}"> Sort By</a></li>
                            <li><a href="#"><img src="{{ asset('user/images/filter.svg') }}"> Filter</a></li>
                        </ul>
                    </div>
                    <div class="row">
    
                        <div class=" col-lg-6 col-md-6">
                            <div class="clubdet">
                                <img src="{{ asset('user/images/bal.png') }}" alt="">
                                <div class="clubprice">
                                    <h2> <a href="#"> putter</a> </h2>
                                    <p>$3/day</p>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-6 col-md-6">
                            <div class="clubdet">
                                <img src="{{ asset('user/images/flag.png') }}" alt="">
                                <div class="clubprice">
                                    <h2> <a href="#"> putter</a> </h2>
                                    <p>$3/day</p>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-6 col-md-6">
                            <div class="clubdet">
                                <img src="{{ asset('user/images/puter.png') }}" alt="">
                                <div class="clubprice">
                                    <h2> <a href="#"> putter</a> </h2>
                                    <p>$3/day</p>
                                </div>
                            </div>
                        </div>
    
                        <div class=" col-lg-6 col-md-6">
                            <div class="clubdet">
                                <img src="{{ asset('user/images/driv.png') }}" alt="">
                                <div class="clubprice">
                                    <h2> <a href="#"> putter</a> </h2>
                                    <p>$3/day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26359294.213879213!2d-113.71754000532059!3d36.247089826313314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sin!4v1661431384168!5m2!1sen!2sin"
                        width="100%" height="642" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="addOnJs"></x-slot>
</x-app-layout>