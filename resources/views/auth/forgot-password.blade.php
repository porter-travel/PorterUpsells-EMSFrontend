<x-guest-layout>

    <div class="mt-20">
        <div class="bg-white px-8 pt-20 pb-12 max-w-[500px] mx-auto rounded-3xl relative">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <form id="reset-password-form" method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autofocus/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button
                        class="g-recaptcha"
                        data-sitekey="6Le7wbIqAAAAAAiTNCo57jYjq57BF4fouKs9hULT"
                        data-callback='onSubmit'
                        data-action='submit'>
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function onSubmit(token) {
            document.getElementById("reset-password-form").submit();
        }
    </script>

</x-guest-layout>
