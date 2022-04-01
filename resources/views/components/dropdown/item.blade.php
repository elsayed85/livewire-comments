<button {{ $attributes->merge(['class' => 'comments-dropdown-item'])->except('icon') }}>
    @isset($icon)
        <x-dynamic-component :component="'comments::icons.' . $icon"/>
    @endisset
    {{ $slot }}
</button>
