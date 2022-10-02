<fieldset>
    <h2>Pickup/dropoff location</h2>
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <ul class="loc">
                <li>Add upto 10 pickup/drop off locations</li>
                <li>Make them free or subject to an additional fee</li>
            </ul>
            <h2>Listing Title</h2>
            <div class="locform">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" name="locationName" placeholder="Enter Location Name" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="">Fee</label>
                            <div class="form_sel">
                                <select id="price" name="priceUnit " class="pric priceUnit">
                                    <option value="usd" selected>USD</option>
                                    <option value="cad">CAD</option>
                                </select>
                                <input type="text" name="price" class="pricinput num" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" id="autocomplete" class="autocomplete" name="address"
                                placeholder="Enter Address" />
                            <input type="hidden" name="fullAddr" id="fullAddr">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" style="width: 10%;height: 10%;" id="isBaseLoc" name="isBaseLoc"
                                /> Base Location
                        </div>
                    </div>


                </div>
                <a href="javascript:void(0)" class="btn1 addLocation">Add Locations </a>
            </div>
            <div class="location-details baseLocation">
                <h2 class="heading">Base Pickup/Dropoff Location</h2>

            </div>
            <div class="location-details otherLocation">
                <h2 class="heading">other Pickup/dropoff location</h2>

            </div>
        </div>

        <div class="col-lg-6 col-md-6 ms-auto">

            <div id="map"></div>
        </div>
    </div>

    {{-- <input type="button" style="display: none" id="proceedStepThree">
    <input type="button" name="next" class="action-button btn proceedStepThree" value="Next" />
    <input type="hidden" name="currentLat" id="currentLat" value="">
    <input type="hidden" name="currentLng" id="currentLng" value=""> --}}

    <input type="button" style="display: none" id="proceedStepThree">
    <div class="row justify-space-between">
        <input type="button" name="next" class="btn previous" style="margin-left: initial !important;"
            value="Prev" />

        
        <input type="button" name="next" class="action-button btn proceedStepThree" value="Next" />
        <input type="hidden" name="currentLat" id="currentLat" value="">
        <input type="hidden" name="currentLng" id="currentLng" value="">
    </div>
</fieldset>
