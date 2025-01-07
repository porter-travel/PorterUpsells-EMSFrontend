@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xl font-regular mb-2']) }}>
    {{ $value ?? $slot }}
</label>
