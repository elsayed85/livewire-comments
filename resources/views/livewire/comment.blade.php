<div
    id="comment-{{ $comment->id }}"
    @class(['comments-group', 'is-top-level' => $comment->isTopLevel()])
    x-data="{ confirmDelete: false }"
>
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
                @unless($isEditing)
                    <x-comments::dropdown>
                        @can('update', $comment)
                            <x-comments::dropdown.item
                                icon="edit"
                                wire:click="startEditing"
                            >
                                {{  __('comments-livewire::comments.edit') }}
                            </x-comments::dropdown.item>
                        @endcan
                        <x-comments::dropdown.item
                            icon="copy"
                            @click="closeDropdown(); navigator.clipboard.writeText(window.location.href.split('#')[0] + '#comment-{{ $comment->id }}')"
                        >
                            {{  __('comments-livewire::comments.copy_link') }}
                        </x-comments::dropdown.item>
                        @can('delete', $comment)
                            <x-comments::dropdown.item
                                icon="delete"
                                @click="confirmDelete = true; dropdownOpen = false"
                            >
                                {{ __('comments-livewire::comments.delete') }}
                            </x-comments::dropdown.item>
                        @endcan
                        @include('comments::livewire.partials.extraCommentHeaderMenuItems')
                    </x-comments::dropdown>
                    <x-comments::modal
                        x-show="confirmDelete"
                        @click.outside="confirmDelete = false"
                        :title="__('comments-livewire::comments.delete_confirmation_title')"
                    >
                        <p>{{ __('comments-livewire::comments.delete_confirmation_text') }}</p>
                        <x-comments::button type="danger" size="small" wire:click="deleteComment">
                            {{ __('comments-livewire::comments.delete') }}
                        </x-comments::button>
                    </x-comments::modal>
                @endunless
            </div>
            @if($isEditing)
                <form wire:submit.prevent="edit">
                    <div x-data="compose({ text: @entangle('editText') })">
                        <div wire:ignore>
                            <textarea placeholder="{{ __('comments-livewire::comments.write_comment') }}">
                                {{ $editText }}
                            </textarea>
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
                <div>{!! $comment->text !!}</div>
                @include('comments::livewire.partials.reactions')
            @endif
        </div>
    </div>
    <div class="comments-nested">
        @foreach ($comment->nestedComments as $nestedComment)
            <livewire:comments-comment :comment="$nestedComment" :key="$nestedComment->id" />
        @endforeach
        @if($comment->isTopLevel())
            @auth
                <div class="comments-form" id="reply-form-{{ $comment->id }}">
                    <x-comments::avatar :comment="$comment" />
                    <form class="comments-form-inner" wire:submit.prevent="reply">
                        <div
                            x-data="{ ...compose({ text: @entangle('replyText'), defer: true }), isExpanded: false }"
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
                            "
                        >
                            <input
                                x-show="!isExpanded"
                                @click="isExpanded = true"
                                class="comments-placeholder"
                                placeholder="{{ __('comments-livewire::comments.write_reply') }}"
                            >
                            <div x-show="isExpanded">
                                <div wire:ignore>
                                    <textarea placeholder="{{ __('comments-livewire::comments.write_reply') }}">
                                        {{ $replyText }}
                                    </textarea>
                                </div>
                                @error('replyText')
                                    <p class="comments-error">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <x-comments::button>
                                    {{ __('comments-livewire::comments.create_reply') }}
                                </x-comments::button>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth
        @endif
    </div>
</div>
