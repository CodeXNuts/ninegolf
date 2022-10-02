    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/jquery-datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('common/plugins/sweetalert2/sweetalert2.min.css') }}" type="text/css">


    <!-- Page CSS -->

    <style>
        .overlay {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: fixed;
        background: rgb(13 110 253 / 25%);
        z-index: 999999999;
    }

    .overlay__inner {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: absolute;
    }

    .overlay__content {
        left: 50%;
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        width: 75px;
        height: 75px;
        display: inline-block;
        border-width: 2px;
        border-left: 6px solid rgba(0, 0, 0, 0.8);
        border-right: 6px solid rgba(0, 174, 239, .8);
        border-bottom: 6px solid rgba(0, 174, 239, .8);
        border-top: 6px solid rgba(0, 174, 239, .8);
        animation: spin 1s infinite linear;
        border-radius: 100%;
        border-style: solid;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }
    </style>