<fieldset>

    <h2>List your club</h2>
    <div class="clubsec">
        <div class="row">
            <div class="col-lg-3 col-md-3">

                <div class="form-group">
                    <input type="text" placeholder="Not applicable" name="listName" id="listNamePlaceholder"
                        class="s1" disabled>
                </div>
                <div class="form-group">
                    <label class="switch">
                        <input type="checkbox" data-heading="Create individual post" data-disabled="true"
                            class="listSetChecker" data-val="individual" data-placeholder="Not applicable"
                            id="listIndv" checked>
                        <span class="slider round"></span>

                    </label>
                    Post individually
                </div>

                <div class="form-group">
                    <label class="switch">
                        <input type="checkbox" data-heading="Create your set" class="listSetChecker" data-val="set"
                            data-placeholder="Set name" id="listSet">
                        <span class="slider round"></span>
                    </label>
                    Post as a Set

                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-6">
                <h3>Gender</h3>
                <ul>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="male"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Male
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="female"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Female
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="junior"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Junior
                            </label>
                        </div>
                    </li>
                </ul>



            </div>
            <div class="col-lg-3 col-md-3 col-6">
                <h3>Dexterity</h3>
                <ul>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dexterity" value="right"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Right
                            </label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dexterity" value="left"
                                id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Left
                            </label>

                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
                <h3>Time Required Prior To Rental</h3>
                <div class="row">
                                 
                        <div class="col-md-6">
                                 <div class="form-check ">
                                    <input class="form-check-input" type="radio"  name="priorTime" value="0"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        No delay
                                    </label>
                             </div>
                        </div>
                        <div class="col-md-6">
                                 <div class="form-check ">
                                    <input class="form-check-input" type="radio"  name="priorTime" value="4"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        4 hours
                                    </label>
                             </div>
                        </div>
             
                          
                     <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  name="priorTime" value="8"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                8 hours
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  name="priorTime" value="12"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                12 hours
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
            
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  name="priorTime" value="24"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                24 hours
                            </label>
                        </div> 
                    
                    </div>
              
                </div>

            </div>

        </div>
    </div>
    <div class="prod-item">
        <div class="row">
            <h2 id="setHeading">Create individual post</h2>
            <x-product-create-prod-type-card title="Driver" dataVal="driver" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="3 wood" dataVal="3 wood" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="5 wood" dataVal="5 wood" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="7 wood" dataVal="7 wood" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="Putter" dataVal="putter" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="Wedge" dataVal="wedge" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="Iron Set" dataVal="iron set" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="Hybrid" dataVal="hybrid" image="user/images/putter.png" />
            <x-product-create-prod-type-card title="Other" dataVal="other" image="user/images/putter.png" />
        </div>
    </div>

    <input type="button" style="display: none" class="proceedStepTwo">
    <input type="button" name="next" class="action-button btn nextStep" value="Next" />
</fieldset>
