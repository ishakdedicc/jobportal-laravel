<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ session('api_token') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet">

    <title>{{$title ?? 'JobPortal | Find and list jobs'}}</title>
</head>

<body class="bg-gray-100">
    <x-header />
    @if(url()->current() === url('/'))
    <x-hero />
    <x-top-banner />
    @endif

    <main class="container mx-auto p-4">

    <div class="max-w-7xl mx-auto p-6">

        @if(session('success'))
            <x-alert type="success" timeout="2000" />
        @endif

        @if(session('error'))
            <x-alert type="error" timeout="4000" />
        @endif

        {{ $slot }}

    </div>
    </main>

    <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>

</body>
</html>
