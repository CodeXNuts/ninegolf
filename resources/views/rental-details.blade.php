<x-app-layout>
    <x-slot name="addOnCss"></x-slot>
    <div class="myaccount">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 dashleft ">
                    <h2>My Account</h2>


                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sec-tab1" data-bs-toggle="tab" data-bs-target="#tab1"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sec-tab2" data-bs-toggle="tab" data-bs-target="#tab2"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">Rented</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sec-tab2" data-bs-toggle="tab" data-bs-target="#tab3"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">Listings</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sec-tab2" data-bs-toggle="tab" data-bs-target="#tab4"
                                type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Analytics</button>
                        </li>


                    </ul>

                </div>
                <div class="col-lg-9 rentdetails ">
                    <ul>
                        <li><a href="#">Rentals</a> </li>
                        <li><a href="#">Club Set</a></li>
                    </ul>

                    <div class="listbox ">

                        <img src="{{ asset('user/images/img01.png') }}" alt="">

                        <div class="listbox-dtl">
                            <h2>Club Set </h2>
                            <h3>$232.49</h3>
                            <p>Pickup Location:<span>3891 Ranchview Dr. Richardson, California 62639</span></p>
                            <p>Rented: <span>14 July, 2022, 04:35 pm Return: 18 July, 2022, 8:00pm</span></p>
                            <p>Paid using Credit card:<span> ***** **** 8988</span></p>
                            <div class="listbox-p2">
                                <h3>Total cost: </h3>
                                <h4>$929.96 <span>*$232.49 x 4 days</span></h4>
                            </div>

                        </div>
                        <div class=" listbox-dtl  listbox-dtl3 ">
                            <h3> <span class="orng">Not Yet Pick </span></h3>
                            <ul>
                                <li><a href="#">Update Status</a>
                                    <!-- <ul class="listbut">
                                    <li><a href="#" class="btn-out"><img src="images/out.svg">Edit</a>
                                    </li>
                                    <li><a href="#" class="btn-in"><img src="images/rightt.svg">In Stock</a>
                                    </li>

                                </ul> -->

                                </li>


                            </ul>


                        </div>


                    </div>


                    <div class="customersec">
                        <h2>Customer Information</h2>
                        <div class="customer-img">
                            <img src="{{ asset('user/images/user.png') }}" alt="">
                            <div class="customer-details">
                                <h3>Jan Kopřiva</h3>
                                <h5>Rating 4.5 10+ • rental delivered successfully </h5>
                                <p>Message</p>
                            </div>
                        </div>
                    </div>
                    <div class="pricesec">
                        <h2>Price details</h2>
                        <table>
                            <tr>
                                <td>Set Price per day</td>
                                <td>$232.49</td>
                            </tr>
                            <tr>
                                <td>Numbers of day/days </td>
                                <td>4</td>
                            </tr>
                            <tr class="amount">
                                <td>Total Amount</td>
                                <td>$929.96</td>
                            </tr>

                        </table>
                        <h3><a href="#">Download Invoice</a></h3>
                        <a href="#" class="epf">Download</a>

                    </div>
                </div>
            </div>
        </div>
    <x-slot name="addOnJs"></x-slot>
</x-app-layout>