<x-app-layout>

    <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
<stripe-pricing-table pricing-table-id="prctbl_1POOrNJQ5u1m2fEsYiEjYjfF"
                      publishable-key="pk_test_51JbMvaJQ5u1m2fEsVWZTXqoAIdRRAb2PDPQ5mxVo1gX0N10WhIJ7kmK0SRfSYlteGMlGTQTuanjqWq1A66LMs7Ej00jB0KD91S"
                      client-reference-id="USER_{{$user->id}}"
customer-email="{{$user->email}}">
</stripe-pricing-table>

</x-app-layout>
