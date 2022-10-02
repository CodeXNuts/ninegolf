<form method="POST"  action="{{ route('login') }}" id="logInForm">
    @csrf
    <div class="form-group">
        <label>Email</label>
        <div class="row">
            <div class="col-md-12">

                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Login Email">

            </div>
            <div class="col-md-12">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password">

            </div>
            <a href="#">Forgot Password?</a>

        </div>
        
    </div>

    <button type="submit" class="btn signupbtn">Sign up</button>
   
    <p>I don’t have an account? <a href="{{ route('register') }}">Sign Up</a></p>
</form>