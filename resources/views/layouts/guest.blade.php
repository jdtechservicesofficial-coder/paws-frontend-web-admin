<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ app_name() }}</title>

    <meta name="setting_options" content="{{ setting('customization_json') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;700&display=swap">
    <style>
        *:not(i):not([class*="fa-"]):not([class*="icon-"]):not(.fa):not(.fas):not(.far):not(.fal):not(.fab):not(.material-icons) {
            font-family: 'Space Grotesk', sans-serif !important;
        }
    </style>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('custom-css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customizer.css') }}">
    @if (isset($styles))
        {{ $styles }}
    @endif

    <style>
      {!! setting('custom_css_block') !!}
    </style>
</head>

<body>
    <!-- Loader Start -->
    <div id="loading">
        <x-partials._body_loader />
    </div>
    <!-- Loader End -->
    <div>
        {{ $slot }}
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/backend.js') }}"></script>

    @if (isset($scripts))
        {{ $scripts }}
    @endif

    <script>
      {!! setting('custom_js_block') !!}
    </script>
</body>

</html>
