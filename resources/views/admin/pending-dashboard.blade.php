<x-app-layout>

    <div class="container mx-auto">
        <h2 class="grandstander uppercase text-4xl mt-8">Subscribe</h2>
    </div>

    @if(env('APP_ENV') == 'production')
        <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
        <stripe-pricing-table pricing-table-id="prctbl_1PM63SJQ5u1m2fEsuJzR9SHZ"
                              publishable-key="pk_live_51JbMvaJQ5u1m2fEsBqIUIR8xy93kpla6UHAGH9xxPgoy8pHmyKWHxwR6WGq6nSHdwBT7xPJgRgJzy6I49Qpu4sEZ00BKCRdldz"
                              client-reference-id="USER_{{$user->id}}"
                              customer-email="{{$user->email}}"
        >
        </stripe-pricing-table>

    @else

        <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
        <stripe-pricing-table pricing-table-id="prctbl_1POOrNJQ5u1m2fEsYiEjYjfF"
                              publishable-key="pk_test_51JbMvaJQ5u1m2fEsVWZTXqoAIdRRAb2PDPQ5mxVo1gX0N10WhIJ7kmK0SRfSYlteGMlGTQTuanjqWq1A66LMs7Ej00jB0KD91S"
                              client-reference-id="USER_{{$user->id}}"
                              customer-email="{{$user->email}}">
        </stripe-pricing-table>
    @endif
</x-app-layout>
