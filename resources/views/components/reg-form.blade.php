<form method="POST" id="regForm" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>NAME</label>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="fname" placeholder="First Name">
            </div>
            <div class="col-md-6">
                <input type="text" name="lname" placeholder="Last Name">
            </div>

        </div>
    </div>
    <div class="form-group">
        <label>Profile image</label>
        <div class="row">
            <div class="col-md-12">
                <img src="https://via.placeholder.com/150" id="file-dp-1-preview" style="" class="" alt="...">
            </div>
            <div class="col-md-12">
                <input id="image" accept="image/*" type="file" name="image" onchange="showPreview();" :value="old('image')"
                autofocus>
            </div>
       

        </div>
    </div>
    <div class="form-group">

        <label>EMAIL</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email Id">
    </div>
    <div class="form-group">

        <label>Phone</label>
        <input type="tel" name="phone" value="{{ old('phone') }}" class="phoneNum" placeholder="Your phone number">
    </div>
    <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" placeholder="Enter your location" value="{{ old('location') }}">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="password">
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" placeholder="Confirm password" name="password_confirmation">
    </div>
    <button type="submit" class="btn signupbtn">Sign up</button>
    <div class="form-group check">
        <input type="checkbox" required>
        I agree with the terms and conditions
    </div>
    <p>Already have an account? <b><a href="#">Log in</a> </b></p>
</form>