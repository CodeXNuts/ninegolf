<x-administrator-guest-layout>
    <x-slot name="addOnCss" >
        
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('administrator.register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <div class="mt-4">
                <img src="https://via.placeholder.com/150" id="file-dp-1-preview" style="height: 100px; width: 100px;" class="rounded float-right inline mb-4" alt="...">
                <x-label for="image" :value="__('Profile image (optional)')" class="font-bold text-sm inline" />
                <x-input id="image" accept="image/*" class=" mt-1 inline w-48" type="file" name="image" onchange="showPreview();" :value="old('image')"
                    autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            <!-- phone number -->
            <div class="mt-4">
                <x-label for="phone" :value="__('Phone No')" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>
            <!-- Address -->
            <div class="mt-4">
                <x-label for="address" :value="__('Address')" />

                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            </div>
            <!-- Address -->
            <div class="mt-4">
                <x-label for="zip" :value="__('Zip')" />

                <x-input id="zip" class="block mt-1 w-full" type="text" name="zip" :value="old('zip')" required />
            </div>
            <!-- Address -->
            <div class="mt-4">
                <x-label for="country" :value="__('Country')" />

                <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('Country')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('administrator.login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
    <x-slot name="addOnJs" >
        <script type="text/javascript">
            function showPreview()
            {
                var src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('file-dp-1-preview').src=src;
            }
        </script>
    </x-slot>
</x-administrator-guest-layout>
