<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bt-auth-btn']) }}>
    {{ $slot }}
</button>
