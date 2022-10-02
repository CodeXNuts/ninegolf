<x-app-layout>
    <x-slot name='addOnCss'>
        <style>
            /* #regForm input {
                color: black;
            }

            #regForm img {
                height: 70px;
                width: 70px;
                border-radius: 50% !important;
                margin-left: 30px;
                margin-top: -10px;
            } */
        </style>
    </x-slot>

    <div class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h2>Sign up</h2>
                    <!-- Validation Errors -->
                    <x-auth-validation-errors style="color: red" class="mb-4" :errors="$errors" />
                    <x-reg-form />

                </div>
                <div class=" col-lg-5">
                    <img src="{{ asset('user/images/contact.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <x-slot name="addOnJs">
        <script type="text/javascript">
            $('.phoneNum').keypress(function(e) {
                var arr = [];
                var kk = e.which;

                for (i = 48; i < 58; i++)
                    arr.push(i);

                if ((!(arr.indexOf(kk) >= 0)) || $(this).val().length > 10)
                    e.preventDefault();
            });

            function showPreview() {
                var src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('file-dp-1-preview').src = src;
            }
        </script>
    </x-slot>
</x-app-layout>
