@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-regular mb-2']) }}>
    {{ $value ?? $slot }}
</label>
