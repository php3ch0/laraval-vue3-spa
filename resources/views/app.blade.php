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
        <meta name="description" content="Computer and laptop repair specialists in Folkestone, Kent. IT Support callouts, Business and Home PC Problems Solved." />
    </noscript>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles.css') }}" rel="stylesheet">
    <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

</head>

<body class="antialiased">
    <div id="app" class="min-h-screen"></div>
</body>

<script>
    window.config = @json($config);
</script>

</html>
