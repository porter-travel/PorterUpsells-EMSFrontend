@php
    use \App\Helpers\Money;
    $price = $attributes['amount'];
    $currency = $attributes['currency'];
@endphp

{{Money::lookupCurrencySymbol($currency)}}{{Money::format($price)}}

