{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}


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
                    <h2>Forgot password?</h2>
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <!-- Validation Errors -->
                    <x-auth-validation-errors style="color: red" class="mb-4" :errors="$errors" />
                    <form method="POST"  action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <div class="row">
                                <div class="col-md-12">
                    
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Login Email">
                    
                                </div>
                            </div>
                            
                        </div>
                    
                        <button type="submit" class="btn signupbtn">submit</button>

                    </form>
                </div>
                
            </div>
        </div>
    </div>
    
    <x-slot name='addOnJs'>
    </x-slot>
</x-app-layout>
