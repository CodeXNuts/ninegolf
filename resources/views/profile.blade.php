<x-app-layout>
    <x-slot name="addOnCss">
        <style>
            .shareUI {
                margin: 12px 0 0;
                position: relative;
                background: #fff;
                box-shadow: 0 0 5px #ddd;
                border-radius: 4px
            }

            .shareUI:before {
                content: "";
                width: 10px;
                height: 10px;
                background: #fff;
                position: absolute;
                top: -4px;
                left: 30px;
                transform: rotate(46deg);
            }

            .myaccount .tab-content .listbox .listbox-dtl .shareUI ul li a {
                background: none
            }
            .swal2-container.swal2-top-end>.swal2-popup, .swal2-container.swal2-top-right>.swal2-popup{
                     width:40% !important;
            }
        </style>
    </x-slot>
    <div class="myaccount">
        <div class="container">
            <div class="row">
                @php
                    $title = 'My Account';
                @endphp
                <x-profile-side-dash-sec :title="$title" />
                <div class="col-lg-9 col-md-9  p-0">
                    <div class="tab-content" id="myTabContent">
                        <x-profile-account-details />
                        <x-rented-sec />
                        <x-list-sec :products="$products" />
                        <x-payment-info-sec :stripeAccountInfo="$stripeAccountInfo"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="addOnJs">
        <script type="text/javascript">
            $('.editProfile').on('click', function() {
                $('#myprof').fadeOut(100);

                $('#edit').fadeIn(100)
            });

            $('.editbutt').on('click', function() {
                $('#editProfImage').trigger('click');
            });

            function showPreview() {
                var src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('editPreview').src = src;
            }
        </script>

        <script src="{{ asset('user/js/pages/profile.js') }}"></script>
        <script src="{{ asset('user/js/pages/payment-info.js') }}"></script>
    </x-slot>
</x-app-layout>
