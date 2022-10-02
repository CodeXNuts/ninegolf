<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('layouts.css.common-css')
    {{ $addOnCss }}
</head>

<body>
    <div class="overlay loader" style="display: none">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>
    @include('layouts.header')
    {{ $slot }}
    @include('layouts.footer')
    @include('layouts.js.common-js')
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
