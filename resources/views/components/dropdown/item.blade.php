<button class="comments-dropdown-item" {{ $attributes->except('icon') }}>
    <x-dynamic-component :component="'comments::icons.' . $icon" />
    {{ $slot }}
</button>
