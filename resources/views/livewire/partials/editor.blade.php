<div
    x-data="compose({ text: @entangle($property) })"
    x-init="
        $wire.on('comment', clear);
        @isset($comment)
            $wire.on('reply-{{ $comment->id }}', () => {
                clear();
            });
        @endisset
    "
>
    <div wire:ignore>
        <textarea placeholder="{{ $placeholder ?? '' }}"></textarea>
    </div>
</div>
