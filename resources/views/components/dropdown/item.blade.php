<button class="comments-dropdown-item" {{ $attributes->except('icon') }}>
    <x-dynamic-component :component="'comments::icon.' . $icon" />
    {{ $slot }}
</button>
