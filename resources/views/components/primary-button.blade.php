<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-1 bg-black text-white grandstander uppercase  rounded-full font-bold text-lg ']) }}>
    {{ $slot }}
</button>
