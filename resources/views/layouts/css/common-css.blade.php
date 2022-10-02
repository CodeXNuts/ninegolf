<link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}" type="text/css">
<link href="{{ asset('user/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('user/css/responsive.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('user/css/slimNav_sk78.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('user/css/other.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('user/css/owl.theme.default.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('common/plugins/sweetalert2/sweetalert2.min.css') }}" type="text/css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css">
<link rel="stylesheet" href="{{ asset('user/css/jquery-ui.css
    ') }}" type="text/css">

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

    header .main-header .menu-sec ul li {
        display: inline-block;
        vertical-align: middle;
        margin: 0 0 0 25px;
    }

    header .main-header .menu-sec ul li a {
        text-decoration: none;
        font-weight: 400;
        margin: 0 5px;
        font-size: 16px;
        line-height: 19px;
        text-transform: capitalize;
        color: #000000;
        display: table;
    }

    img.profile {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }

    .swal2-container.swal2-top-end>.swal2-popup,
    .swal2-container.swal2-top-right>.swal2-popup {
        grid-column: 3;
        align-self: start;
        justify-self: end;
        position: fixed;
        top: 10px;
        width: 22% !important;
    }

    .KK-o3G {
    position: absolute;
    left: 16px;
    bottom: 18px;
    text-align: center;
    border-radius: 11px;
    width: 21px;
    height: 20px;
    background-color: #ff6161;
    border: 1px solid #fff;
    font-weight: 400;
    color: #f0f0f0;
    line-height: 18px;
    font-size: 12px;
}
</style>
