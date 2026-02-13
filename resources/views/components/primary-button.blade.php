<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-primary-900 hover:bg-primary-950 text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition-all shadow-lg shadow-primary-900/20 active:scale-95']) }}>
    {{ $slot }}
</button>
