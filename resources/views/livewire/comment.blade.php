<div id="comment-{{ $comment->id }}" @class(['comments-group', 'is-top-level' => $comment->isTopLevel()])>
    <div class="comments-comment">
        <x-comments::avatar :comment="$comment" />
        <div class="comments-comment-inner">
            <div class="comments-comment-header">
                @if($url = $comment->commentatorProperties()->url)
                    <a href="{{ $url }}">
                        {{ $comment->commentatorProperties()->name }}
                    </a>
                @else
                    {{ $comment->commentatorProperties()->name }}
                @endif
                <div class="divider"></div>
                <a href="#comment-{{ $comment->id }}">
                    <x-comments::date :date="$comment->created_at" />
                </a>
                @include('comments::livewire.partials.commentHeaderMenu')
            </div>

            <div>
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
                        <x-comments::avatar :comment="$comment" />
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
