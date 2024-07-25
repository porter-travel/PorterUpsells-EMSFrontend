<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Success!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">



            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <p>Thank you for setting up your connected Stripe Account.<br>  You will be redirected to your dashboard shortly</p>
                    <p>If you are not redirected in 5 seconds, <a href="{{route('dashboard')}}">please click here.</a></p>
                </div>
            </div>

            <script>
                setTimeout(function() {
                    window.location.href = "{{route('dashboard')}}";
                }, 5000);
            </script>

        </div>
    </div>
</x-app-layout>
