@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bt-auth-input']) }}>
