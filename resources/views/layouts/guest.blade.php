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

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title ?? 'Enhance My Stay'}}</title>
    <link rel="icon" type="image/x-icon" href="{{$favicon ?? '/img/hank.png'}}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=grandstander:700,900|open-sans:400,700" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body style="min-height: 100vh" class="font-sans antialiased flex flex-col ">
<div class="container mx-auto">
    {{$slot}}
</div>

<footer class="mt-auto pb-8">
    <div class="mx-auto text-center">
        <img class="mx-auto mb-4 mt-24" src="/img/logo.svg" alt="logo">
        <p class="open-sans">Personalising your stay</p>
    </div>
</footer>
</body>

</html>
