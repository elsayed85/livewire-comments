@can('createComment', $model)
<div class="comment-form ">
    @auth
    <div>
        <div class="avatar">
            @include('comments::livewire.partials.avatar')
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

<style>
    .comment-form {
        background-color: rgb(249 250 251);
        padding: 1.5rem 1rem;
    }

    .comment-form>div {
        display: flex;

    }

    .comment-form .avatar {
        flex-shrink: 0;
        margin-right: 1rem;
    }

    .comment-form .form-body {
        flex: 1 1 0%;
        min-width: 0;
    }

    .comment-form .submit-button, .comments-wrapper .error-message {
        margin-top: .5rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: rgb(239 68 68);
    }
    .comment-form .submit-button, .comments-wrapper .submit-button, .markdown .submit-button{
        margin-top: .75rem;
        display: flex;
        align-items: center;
    }
    .comment-form .submit-button> :not([hidden])~ :not([hidden]), .comments-wrapper .submit-button > :not([hidden])~ :not([hidden]), .markdown .submit-button  > :not([hidden])~ :not([hidden])	{
        margin-left: 1rem;
    }

    .comment-form .submit-button button, .comments-wrapper .submit-button button, .markdown .submit-button button{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .5rem 1rem;
        border: 1px solid rgba(0,0,0,0);
        font-weight: 500;
        border-radius: .375rem;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        color: white;
        background-color: #4338ca;
    }

    .markdown .submit-button .cancel-button{
        background-color: rgb(209 213 219);
        color: black;
    }


    .comment-form .submit-button button:hover, .comments-wrapper .submit-button button:hover, .markdown .submit-button button:hover{
        background-color: rgba(67, 56, 202, .75);
        color: white
    }

    .comment-form .submit-button button:focus, .comments-wrapper .submit-button button:focus, .markdown .submit-button button:focus{
        --tw-ring-inset: inset;
        box-shadow: var(--tw-ring-inset) 0 0 0 calc(2px) rgba(67, 56, 202, .75);
    }


    @media (min-width: 640px) {
        .comment-form {
            padding: 1.5rem 1.5rem;
        }
    }
</style>