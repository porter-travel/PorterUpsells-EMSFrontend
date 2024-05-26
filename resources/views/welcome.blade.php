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

    <title>Enhance My Stay</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=grandstander:700,900|open-sans:400,700" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="">

<div class="bg-yellow py-4">
    <div class="container mx-auto">
        <div class="flex items-center justify-between">
            <img src="/img/logo.svg" alt="logo">

            {{--            <nav>--}}
            {{--                <ul class=" list-none flex items-center justify-end">--}}
            {{--                    <li class="mr-4">--}}
            {{--                        <a class="no-underline open-sans" href="/hotels">Hotels</a>--}}
            {{--                    </li>--}}
            {{--                    <li class="mr-4">--}}
            {{--                        <a class="no-underline open-sans" href="/airbnbs">Airbnbs</a>--}}
            {{--                    </li>--}}
            {{--                    <li class="mr-4">--}}
            {{--                        <a class="no-underline open-sans" href="/about">About</a>--}}
            {{--                    </li>--}}
            {{--                    <li class="mr-4">--}}
            {{--                        <a class="no-underline open-sans" href="/contact">Contact</a>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </nav>--}}
        </div>
    </div>
</div>

<div class="bg-pink">
    <div class="narrow-container mx-auto py-4 relative">
        <img src="/img/hank.png" alt="hank" class="absolute sm:right-0 right-4 max-w-[66px] sm:max-w-lg top-[222px] sm:top-[180px] lg:translate-x-1/2">
        <div class="flex justify-between items-center">
            <div class="text-center relative pb-[200px] sm:pb-[400px]">
                <p class="text-black grandstander font-black lg:text-6xl md:text-4xl text-2xl leading-tight mt-8 mb-6">
                    IMPROVE GUEST EXPERIENCE AND GENERATE MORE INCOME PRE-ARRIVAL
                </p>
                <p class="open-sans md:text-2xl text-large ">We create tools to help you easily upsell<br> products and services to
                    your guests</p>
                <div class="max-w-[200px] sm:max-w-full mx-auto">
                <a href="{{route('register')}}"
                   class=" grandstander bg-black sm:text-2xl text-lg border-t-2 border-l-2 border-r-8 border-b-8 text-black rounded-lg mt-4 inline-block">
                    <span class="bg-mint rounded-lg py-4 px-4 sm:px-8 block leading-none">
                    START UPSELLING FOR FREE
                        </span>
                </a>
                </div>

                <img src="/img/landing-panels.png" alt="panels" class="lg:mt-12 sm:mt-40 mt-12 h-[300px] sm:h-[400px] md:h-[600px] w-full object-contain absolute">
            </div>
        </div>
    </div>
</div>

<div class="bg-lightBlue pt-[300px] pb-[150px] sm:pb-[300px]">
    <div class="narrow-container mx-auto py-4 text-center">
        <h3 class="grandstander md:text-4xl text-2xl uppercase mb-8">help your guests enhance their stay</h3>
        <p class="open-sans md:text-2xl text-lg mb-20">We’ve built the world’s best upsell platform and we want you to have
            it...FOR
            FREE! Add the products you want to offer and start offering upsells directly to your guests before they
            arrive. With no upfront costs, we only earn when you do! </p>
        <div class="flex items-center md:justify-center justify-around absolute w-full mx-auto left-0">
            <img class="md:mx-8 max-w-[40%]" src="/img/landing/help1.png" alt="">
            <img class="md:mx-8 max-w-[40%]" src="/img/landing/help2.png" alt="">
        </div>
    </div>
</div>

<div class="bg-mint pt-[200px] pb-[150px]">
    <div class="container mx-auto text-center">
        <a href="{{route('register')}}"
           class=" grandstander bg-black text-2xl border-t-2 border-l-2 border-r-8 border-b-8 text-black  rounded-lg mt-4 inline-block">
            <span class="bg-pink rounded-lg py-4 px-8 block">Get Started</span>
        </a>
        <h3 class="grandstander  md:text-4xl text-2xl  uppercase mb-16 mt-16">DON’T JUST EARN WHEN YOUR GUESTS BOOK</h3>

        <div class="flex flex-wrap text-left">
            <div class="md:basis-1/3 basis-full px-4 text-center md:text-left pb-12">
                <h4 class="grandstander text-2xl pb-6">Targeted delivery</h4>
                <p class="open-sans md:text-2xl text-lg">Our upsell platform is strategically designed to engage guests 1-3 weeks
                    before their arrival,
                    tapping into key insights from hospitality professionals about guest spending behaviour</p>
            </div>

            <div class="md:basis-1/3 basis-full px-4 text-center md:text-left pb-12">
                <h4 class="grandstander text-2xl pb-6">Cost perception</h4>
                <p class="open-sans md:text-2xl text-lg ">Once a booking is secured, guests tend to mentally 'move past' the
                    initial expense, making them more
                    open to enhancing their upcoming stay as the anticipation builds</p>
            </div>

            <div class="md:basis-1/3 basis-full px-4 text-center md:text-left pb-12">
                <h4 class="grandstander text-2xl pb-6">Optimised for success</h4>
                <p class="open-sans md:text-2xl text-lg">By reducing the amount of options and information presented at the point
                    of booking, and ‘unpacking
                    the cost’ for your guest, our upsell tool is optimised to help boost your pre-arrival income</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-purple py-32">
    <div class="container mx-auto ">
        <h3 class="grandstander text-4xl uppercase mb-8 text-center">BUILT BY TRAVEL LOVERS, FOR TRAVEL LOVERS 🩷</h3>
        <div class="flex items-start justify-between flex-wrap">

            <div class="lg:basis-1/3 md:basis-1/2 basis-full text-center md:text-left px-4 mb-12">
                <h4 class="grandstander text-2xl mb-8">Custom branding</h4>
                <p class="open-sans md:text-2xl text-lg">We’ve designed our portal to reflect your brand, with your logo, colours
                    and fonts</p>
            </div>

            <div class="lg:basis-1/3 md:basis-1/2 basis-full text-center md:text-left px-4 mb-12">
                <h4 class="grandstander text-2xl mb-8">Your products & services</h4>
                <p class="open-sans md:text-2xl text-lg ">Easily offer the products and services you want, tailored to your
                    guests</p>
            </div>

            <div class="lg:basis-1/3 md:basis-1/2 basis-full text-center md:text-left px-4 mb-12">
                <h4 class="grandstander text-2xl mb-8">Mobile payments</h4>
                <p class="open-sans md:text-2xl text-lg ">Ensure maximum conversion with one click payments from Google and Apple
                    Pay</p>
            </div>

            <div class="lg:basis-1/3 md:basis-1/2 basis-full text-center md:text-left px-4 mb-12">
                <h4 class="grandstander text-2xl mb-8">Quick-start</h4>
                <p class="open-sans md:text-2xl text-lg">Our simple set-up technology means you can start offering upsells with no
                    technical work needed</p>
            </div>

            <div class="lg:basis-1/3 md:basis-1/2 basis-full text-center md:text-left px-4 mb-12">
                <h4 class="grandstander text-2xl mb-8">Multi-currency</h4>
                <p class="open-sans md:text-2xl text-lg ">Want to offer products to different markets? We can help you offer
                    upsells in multiple currencies</p>
            </div>

            <div class="lg:basis-1/3 md:basis-1/2 basis-full text-center md:text-left px-4 mb-12">
                <h4 class="grandstander text-2xl mb-8">Continuous improvements</h4>
                <p class="open-sans md:text-2xl text-lg ">Each time we add more features to our platform, we’ll upgrade your
                    account automatically</p>
            </div>
        </div>

        <div class="text-center">
            <a href="{{route('register')}}"
               class=" grandstander bg-black text-2xl border-t-2 border-l-2 border-r-8 border-b-8 text-black  rounded-lg mt-4 inline-block">
                <span class="bg-yellow rounded-lg py-4 px-8 block">Start Offering Upsells</span>
            </a>
        </div>
    </div>
</div>

<div class="bg-yellow py-20">
    <div class="narrow-container mx-auto text-center relative">

        <p class="text-black grandstander font-black lg:text-6xl md:text-4xl text-2xl leading-tight mb-12">
            LET US HELP YOU UPSELL TO YOUR GUESTS
        </p>

        <img loading="lazy" src="/img/hank.png" alt="hank" class="md:absolute top-0 left-0 md:-translate-x-[130%] mx-auto">

        <a href="{{route('register')}}"
           class=" grandstander bg-black text-2xl border-t-2 border-l-2 border-r-8 border-b-8 text-black  rounded-lg mt-4 inline-block">
                    <span class="bg-lightBlue rounded-lg py-4 px-8 block">
                    Book a Demo
                        </span>
        </a>
    </div>

    <div class="container mx-auto border-t border-black mt-12 pt-8">
        <img src="/img/logo.svg" alt="logo">
        <p class="mt-4">Copyright © 2024 Travel Global Limited. All rights reserved</p>
    </div>
</div>

</body>
</html>
