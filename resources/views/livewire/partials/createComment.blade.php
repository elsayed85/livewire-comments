@can('createComment', $model)
<div class="comment-form ">
    @auth
    <div>
        <div class="avatar">
            <x-comments::avatar />
        </div>
        <div class="form-body">
            <form wire:submit.prevent="comment">
                <div x-data="compose({ text: @entangle('text') })" x-init="$wire.on('comment', clear)">
                    <div wire:ignore>
                        <textarea
                            placeholder="{{ __('comments-livewire::comments.write_comment') }}">{{ $text }}</textarea>
                    </div>
                </div>
                @error('text')
                <p class="error-message ">
                    {{ $message }}
                </p>
                @enderror
                <div class="submit-button">
                    <button type="submit">
                        {{ __('comments-livewire::comments.create_comment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @else
    <p>Log in to comment</p>
    @endauth
</div>
@endcan
