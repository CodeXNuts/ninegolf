<div class="tab-pane fade flexing active  show profTabs" id="tab1" role="tabpanel" aria-labelledby="home-tab">
    <div class="edit-prf1" id="myprof">
        <img src="{{ auth('web')->user()->avatar ? URL('/' . auth('web')->user()->avatar) : '' }}" alt=""
            style="height: 194px;width: 194px" class="frstimg rounded-circle">

        <h3>Name</h3>
        <p>{{ auth('web')->user()->fname ?? '--' }} {{ auth('web')->user()->lname ?? '--' }}</p>
        {{-- <h3> Location</h3>
        <p> {{ auth('web')->user()->location ?? 'N.A' }}</p> --}}
        <h3> Email</h3>
        <p>{{ auth('web')->user()->email ?? 'N.A' }}</p>
        <h3> Phone number</h3>
        <p>{{ auth('web')->user()->phone ?? 'N.A' }}</p>
        <a href="javascript:;" class="epf editProfile">Edit proflie</a>
    </div>
    <div  style="display: none;" class="edit-prf" id="edit">
        <div class="col-lg-6">
            <div class="editsec">
                <img src="{{ auth('web')->user()->avatar ? URL('/' . auth('web')->user()->avatar) : '' }}" id="editPreview" class="rounded-circle"
                    alt="">
                <div class="editbutt">
                    <span>
                        <img src="{{ asset('user/images/edit.svg') }}"  alt=""></span>
                </div>

            </div>
            <form method="POST" action="{{ route('user.profile.update',['user'=>auth('web')->id()]) }}" enctype="multipart/form-data" id="editProfileForm">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="row">
                        <input type="file" style="display: none" name="editImage" id="editProfImage" onchange="showPreview()" />
                        <div class="col-md-6">
                            <label for="">First Name</label>
                            <input type="text" name="fname" value="{{ auth('web')->user()->fname ?? '--' }}" placeholder="Enter your first name">
                        </div>
                        <div class="col-md-6">
                            <label for="">Last Name</label>
                            <input type="text" name="lname" value="{{ auth('web')->user()->lname ?? '--' }}" placeholder="Enter your last name">
                        </div>

                    </div>

                    {{-- <div class="form-group">
                        <label for="">Location</label>
                        <input type="text" name="location" value="{{ auth('web')->user()->location ?? '--' }}" placeholder="Address">

                    </div> --}}
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="Email" name="email" value="{{ auth('web')->user()->email ?? '--' }}" placeholder="Email">

                    </div>
                    <div class="form-group">
                        <label for="">Phone number</label>
                        <input type="tel" name="phone" value="{{ auth('web')->user()->phone ?? '--' }}" placeholder="Phone No">

                    </div>
                    <a href="javascript:;" class="epf epf2" id="updateProfile" onclick="document.getElementById('editProfileForm').submit()">Save
                        Change</a>
            </form>

            
        </div>
    </div>
</div>
</div>
