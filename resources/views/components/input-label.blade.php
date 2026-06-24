@props(['value'])

<label {{ $attributes->merge(['class' => 'bt-auth-label']) }}>
    {{ $value ?? $slot }}
</label>
