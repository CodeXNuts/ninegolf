<x-app-layout>
    <x-slot name="addOnCss">

    </x-slot>
    <div class="liststep">
        <div class="tabs">
            <ul id="progressbar">
                <li class="active">
    
                </li>
                <li>
    
                </li>
                <li>
    
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>List your club</h2>
                    <div class="clubsec">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <form action="" method="POST" name="stepOneForm" id="stepOneForm">
                                    <input type="hidden" name="listType" id="listType" value="individual">
                                    <input type="hidden" name="clubs" id="clubs" value="[]">
                                    <div class="form-group">
                                        <input type="text" placeholder="Not applicable" name="listName"  id="listNamePlaceholder" class="s1" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="switch">
                                            <input type="checkbox" data-heading="Create individual post" data-disabled="true" class="listSetChecker" data-val="individual" data-placeholder="Not applicable" id="listIndv" checked>

                                            <span class="slider round"></span>
    
                                        </label> Post individually
    
                                    </div>
    
                                    <div class="form-group">
                                        <label class="switch">
                                            <input type="checkbox" data-heading="Create your set" class="listSetChecker" data-val="set" data-placeholder="Set name" id="listSet" >
                                            <span class="slider round"></span>
                                        </label>
                                        Post as a Set
                                    </div>
    

                            </div>
                            <div class="col-lg-3 col-md-3">
                                <h3>Gender</h3>
                                <ul>
                                    <li><input type='radio' name="gender" value="male" />Male </li>
                                    <li><input type='radio' name="gender" value="female" />Female</li>
                                    <li><input type='radio' name="gender" value="junior"/>Junior </li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <h3>Dexterity</h3>
                                <ul>
                                    <li><input type='radio' name="dexterity" value="right"/>Right </li>
                                    <li><input type='radio' name="dexterity" value="left"/>Left </li>
    
                                </ul>
                            </div>
    
                            <div class="col-lg-3 col-md-3">
    
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
    
                    <a href="javascript::void(0)" class="btn nextStep">Next</a>
                </form>
                </div>
            </div>
        </div>
    </div>
      
    <x-slot name="addOnJs">
        
        <script src="{{ asset('user/js/pages/list-step-one.js')}}"></script>
    </x-slot>
</x-app-layout>