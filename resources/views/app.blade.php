@php
    $config = [
        'appName' => config('app.name'),
        'appURL' => config('app.url')
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
    <meta charset="utf-8">
        <title>{{ getenv('APP_NAME') }}</title>
    <noscript>
        <meta name="description" content="Portside Recruitment" />
    </noscript>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;500&display=swap" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>

</head>

<body class="antialiased">
    <div id="app" class="min-h-screen"></div>
</body>

<script>
    window.config = @json($config);
</script>

</html>
