<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name'))</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

   

    <!-- Global Stylesheets -->
    <link href="{{ asset('assets/css/plugins.bundle.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />

    @stack('styles')
</head>