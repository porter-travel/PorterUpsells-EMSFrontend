<x-guest-layout>

    <div class="mt-20">
        <div class="bg-white px-8 pt-20 pb-12 max-w-[500px] mx-auto rounded-3xl relative">
            <form id="register-form" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                  required autofocus autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button
                        class="g-recaptcha ms-4 inline-flex items-center px-8 py-1 bg-black text-white font-sans uppercase  rounded-full font-bold text-lg "
                        data-sitekey="6Le7wbIqAAAAAAiTNCo57jYjq57BF4fouKs9hULT"
                        data-callback='onSubmit'
                        data-action='submit'>
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function onSubmit(token) {
            document.getElementById("register-form").submit();
        }
    </script>
</x-guest-layout>
