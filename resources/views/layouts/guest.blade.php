<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SJTMEB0Y01"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-SJTMEB0Y01');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=grandstander:700,900|open-sans:400,700" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="min-height: 100vh" class="font-sans antialiased flex flex-col ">
<div class="container mx-auto">
    {{$slot}}
</div>

<footer class="mt-auto pb-8">
    <div class="mx-auto text-center">
        <img class="mx-auto mb-4" src="/img/logo.svg" alt="logo">
        <p class="open-sans">Personalising your hotel experience</p>
    </div>
</footer>
</body>

</html>
