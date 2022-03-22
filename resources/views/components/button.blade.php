@php
    $type ??= null;
    $size ??= null;
    $htmlType ??= 'button';
@endphp
<button
    type="{{ $htmlType }}"
    @class([
        'comments-button',
        'is-normal' => $size === 'normal',
        'is-small' => $size === 'small',
        'is-primary' => $type === 'primary',
        'is-danger' => $type === 'danger',
    ])"
    {{ $attributes->except('type', 'size', 'htmlType') }}
>
    {{ $slot }}
</button>
