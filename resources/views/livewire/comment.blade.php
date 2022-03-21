<div id="comment{{ $comment->id }}" @class(["comment-top-level"=> $comment->isTopLevel()])
    >
    <div class="comment-wrapper">
        <div @class(["avatar", "top-level"=> $comment->isTopLevel()])>
            @include('comments::livewire.partials.avatar')
        </div>

        <div @class(['comment-body', 'top-level'=> $comment->isTopLevel()])>
            @include('comments::livewire.partials.commentHeader')

            <div class=" markdown @if($comment->isTopLevel()) toplevel-markdown @endif">
                @if ($isEditing)
                <form wire:submit.prevent="edit">
                    <div x-data="compose({ text: @entangle('editText') })">
                        <div wire:ignore>
                            <textarea
                                placeholder="{{ __('comments-livewire::comments.write_comment') }}">{{ $editText }}</textarea>
                        </div>
                    </div>
                    @error('editText')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                    @enderror
                    <div class="submit-button">
                        <button type="submit">
                            {{ __('comments-livewire::comments.edit_comment') }}
                        </button>
                        <button class="cancel-button" type="button">
                            {{ __('comments-livewire::comments.cancel') }}
                        </button>
                    </div>
                </form>
                @else
                <div class="comment-text">{!! $comment->text !!}</div>
                @endif
            </div>

            @include('comments::livewire.partials.reactions')
        </div>
    </div>

    <div class="nested-comments-wrapper">
        @foreach ($comment->nestedComments as $nestedComment)
        <livewire:comments-comment :comment="$nestedComment" :key="$nestedComment->id" />
        @endforeach
        @if($comment->isTopLevel())
        @auth
        <div id="reply-form-{{ $comment->id }}">
            <form wire:submit.prevent="reply">
                <div class="comment-form">
                    <div class="avatar">
                        @include('comments::livewire.partials.avatar')
                    </div>
                    <div>
                        <div x-data="{ ...compose({ text: @entangle('replyText'), defer: true }), isExpanded: false }"
                            x-init="
                                        $wire.on('reply-{{ $comment->id }}', () => {
                                            clear();
                                            isExpanded = false;
                                        });
                                        $watch('isExpanded', (isExpanded) => {
                                            if (isExpanded) {
                                                load();
                                            }
                                        });
                                    ">
                            <input x-show="!isExpanded" @click="isExpanded = true"
                                placeholder="{{ __('comments-livewire::comments.write_reply') }}">
                            <div x-show="isExpanded" wire:ignore>
                                <textarea
                                    placeholder="{{ __('comments-livewire::comments.write_reply') }}">{{ $replyText }}</textarea>
                            </div>
                        </div>
                        @error('replyText')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                        @enderror
                        <div class="submit-button">
                            <button type="submit">
                                {{ __('comments-livewire::comments.create_reply') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endauth
        @endif
    </div>
</div>

<style>
    .comment-top-level {
        background-color: white;
        border-bottom: 1px solid rgb(209 213 219);
        padding-bottom: 2rem;
    }

    .comment-wrapper {
        display: flex;
        padding: 1rem;
        padding-bottom: 0;
        border-radius: 0.375rem;
    }

    .avatar {
        flex-shrink: 0;
        margin-right: 1rem;
        margin-top: 1rem;
    }

    .avatar img {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 99999px
    }

    .avatar.top-level {
        margin-top: 0rem;
    }

    .comment-body {
        flex-grow: 1;
        padding: 1rem;
        border: 1px solid rgb(209 213 219);
        border-radius: 0.375rem;
    }

    .comment-body.top-level {
        padding: 0;
        border: none;
    }

    .markdown {
        margin-top: .25rem;
        flex-grow: 1;
        width: 100%;
    }

    .markdown .shiki {
        background-color: #f5f5f5 !important;
        padding: 0.5rem;
        border-radius: 0.375rem;
    }

    .comments-wrapper .error-message {
        margin-top: .5rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: rgb(239 68 68);
    }

    .comment-text {
        color: rgb(55 65 81);
    }

    .nested-comments-wrapper .comment-form {
        display: flex;
        border: 1px solid rgb(209 213 219);
        padding: 1rem;
        border-radius: .375rem;
    }

    .nested-comments-wrapper .comment-form>div {
        display: inline-block;
        flex: 1 1 0%;
    }

    .nested-comments-wrapper .comment-form .avatar {
        flex: none;
    }

    .nested-comments-wrapper .comment-form input {
        width: 100%;
        border: 1px solid rgb(209 213 219);
        padding: 1rem;
        border-radius: .375rem;
    }

    .nested-comments-wrapper {
        margin-left: 4.5rem;
        margin-top: 1.5rem;
        position: relative;
    }
</style>