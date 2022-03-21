<button class="comments-dropdown-item" {{ $attributes->except('icon') }}>
    @include('comments::livewire.svgs.' . $icon)
    {{ $slot }}
</button>
