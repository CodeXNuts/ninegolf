<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @include('administrator.layouts.css.common-css')
    {{ $addOnCss }}
</head>

<body>
    <div class="overlay loader" style="display: none">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <x-admin.aside-navbar />

            <!-- Layout container -->
            <div class="layout-page">
                <x-admin.top-navbar/>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('administrator.layouts.js.common-js')
    {{ $addOnJs }}

    {{-- Show common toast notification --}}
    @if (session()->has('success'))
        <script type="text/javascript">
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            })
        </script>
    @endif
    @if (session()->has('fail'))
        <script type="text/javascript">
            Toast.fire({
                icon: 'error',
                title: "{{ session('fail') }}"
            })
        </script>
    @endif
</body>

</html>
