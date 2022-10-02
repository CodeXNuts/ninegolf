<x-app-layout>
    <x-slot name="addOnCss">

        <style>
            #map {
                width: 100%;
                max-width: 768px;
                max-height: 900px;
                height: 90%;
            }
        </style>
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
                <form class="msform" action="" method="POST" name="stepOneForm" id="stepOneForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="listType" id="listType" value="individual">
                    <input type="hidden" name="isMix" id="isMix" value="false">
                    <input type="hidden" name="clubs" id="clubs" value="[]">
                    {{-- <input type="hidden" name="clubAddress" id="clubAddress" value="[]"> --}}
                    <x-step-one-form-sec />
                    <x-step-two-form-sec />
                    <x-step-three-form-sec />
                </form>
            </div>
        </div>
    </div>

    <x-edit-location-modal />
    <x-slot name="addOnJs">
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD50ia6qUmMpfh67VL2pDH2agjayxPww9U">
        </script>
        <script src="{{ asset('user/js/pages/list-step-one.js') }}"></script>
        <script src="{{ asset('user/js/pages/list-step-two.js') }}"></script>
        <script src="{{ asset('user/js/pages/list-step-three.js') }}"></script>
        <script type="text/javascript">
            window.initMap = initMap(36.778259, -119.417931);
        </script>
    </x-slot>
</x-app-layout>
