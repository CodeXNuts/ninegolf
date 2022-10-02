<x-app-layout>
    <x-slot name='addOnCss'>
        <style>
            #logInForm input {
                color: black;
            }
        </style>
    </x-slot>
    <div class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <h2>Log In</h2>
                    <!-- Validation Errors -->
                    <x-auth-validation-errors style="color: red" class="mb-4" :errors="$errors" />
                    <x-login-form />
                </div>
                <div class=" col-lg-5 col-md-5">
                    <img src="{{ asset('user/images/loginpic.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name='addOnJs'>
    </x-slot>
</x-app-layout>