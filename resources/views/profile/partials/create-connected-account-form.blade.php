<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Setup Payments') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('To take payments you will need to authorise through our payment provider Stripe, it only takes 3 minutes to do') }}
        </p>
    </header>

    <form method="post" action="{{ route('connected-account.create') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="country_code" :value="__('Country')"/>
            <select required name="country_code" id="country_code">
                <!-- All Countries where Stripe is available -->
                <option></option>
                <option value="GB">United Kingdom</option>
                <option value="US">United States</option>
                <option value="CA">Canada</option>
                <option value="AU">Australia</option>
                <option value="DE">Germany</option>
                <option value="FR">France</option>
                <option value="ES">Spain</option>
                <option value="IT">Italy</option>
                <option value="NL">Netherlands</option>
                <option value="BE">Belgium</option>
                <option value="AT">Austria</option>
                <option value="PT">Portugal</option>
                <option value="IE">Ireland</option>
                <option value="LU">Luxembourg</option>
                <option value="FI">Finland</option>
                <option value="SE">Sweden</option>
                <option value="DK">Denmark</option>
                <option value="NO">Norway</option>
                <option value="CH">Switzerland</option>
                <option value="HK">Hong Kong</option>
                <option value="SG">Singapore</option>
                <option value="JP">Japan</option>
                <option value="NZ">New Zealand</option>
            </select>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Setup') }}</x-primary-button>
        </div>
    </form>
</section>
