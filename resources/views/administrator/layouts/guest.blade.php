<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{ URL('resources/css/app.css') }}">
    <script src="{{ URL('resources/js/app.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $addOnCss }}
</head>
<body>
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
</div>
{{ $addOnJs }}
</body>
</html>
