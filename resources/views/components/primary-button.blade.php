<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-4 bg-mint  rounded-xl font-bold text-2xl text-black']) }}>
    {{ $slot }}
</button>
