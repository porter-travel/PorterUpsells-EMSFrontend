@props(['disabled' => false])

<input type="color" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'mr-4']) !!}>
