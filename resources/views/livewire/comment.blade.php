<div
    id="comment-{{ $comment->id }}"
    class="comments-group"
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
                                {{  __('comments::comments.edit') }}
                            </x-comments::dropdown.item>
                        @endcan
                        <x-comments::dropdown.item
                            icon="copy"
                            @click="closeDropdown(); navigator.clipboard.writeText(window.location.href.split('#')[0] + '#comment-{{ $comment->id }}')"
                        >
                            {{  __('comments::comments.copy_link') }}
                        </x-comments::dropdown.item>
                        @can('delete', $comment)
                            <x-comments::dropdown.item
                                icon="delete"
                                @click="confirmDelete = true; dropdownOpen = false"
                            >
                                {{ __('comments::comments.delete') }}
                            </x-comments::dropdown.item>
                        @endcan
                        @include('comments::livewire.partials.extraCommentHeaderMenuItems')
                    </x-comments::dropdown>
                    <x-comments::modal
                        x-show="confirmDelete"
                        @click.outside="confirmDelete = false"
                        :title="__('comments::comments.delete_confirmation_title')"
                    >
                        <p>{{ __('comments::comments.delete_confirmation_text') }}</p>
                        <x-comments::button danger small wire:click="deleteComment">
                            {{ __('comments::comments.delete') }}
                        </x-comments::button>
                    </x-comments::modal>
                @endunless
            </div>
            @if($isEditing)
                <div class="comments-form">
                    <form class="comments-form-inner" wire:submit.prevent="edit">
                        @include('comments::livewire.partials.editor', ['property' => 'editText'])
                        @error('editText')
                            <p class="comments-error">
                                {{ $message }}
                            </p>
                        @enderror
                        <x-comments::button submit>
                            {{ __('comments::comments.edit_comment') }}
                        </x-comments::button>
                        <x-comments::button link wire:click="stopEditing">
                            {{ __('comments::comments.cancel') }}
                        </x-comments::button>
                    </form>
                </div>
            @else
                <div>{!! $comment->text !!}</div>
                <div class="comments-reactions">
                    @foreach($comment->reactions->summary() as $summary)
                        <div
                            wire:click="deleteReaction('{{ $summary['reaction'] }}')"
                            @class(['comments-reaction', 'is-reacted' => $summary['commentator_reacted']])
                        >
                            {{ $summary['reaction'] }} {{ $summary['count'] }}
                        </div>
                    @endforeach
                    <div
                        x-cloak
                        x-data="{ open: false }"
                        @click.outside="open = false"
                        class="comments-reaction-picker"
                    >
                        @can('react', $comment)
                            <button class="comments-reaction-picker-trigger" type="button" @click="open = !open">
                                <x-comments::icons.smile />
                            </button>
                            <x-comments::modal x-show="open" compact left>
                                <div class="comments-reaction-picker-reactions">
                                    @foreach(config('comments.allowed_reactions') as $reaction)
                                        @php
                                            $commentatorReacted = ! is_bool(array_search(
                                                $reaction,
                                                array_column($comment->reactions()->get()->toArray(), 'reaction'),
                                            ));
                                        @endphp
                                        <button
                                            type="button"
                                            @class(['comments-reaction-picker-reaction', 'is-reacted' => $commentatorReacted])
                                            @if($commentatorReacted)
                                                wire:click="deleteReaction('{{ $reaction }}')"
                                            @else
                                                wire:click="react('{{ $reaction }}')"
                                            @endif
                                        >
                                            {{ $reaction }}
                                        </button>
                                    @endforeach
                                </div>
                            </x-comments::modal>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if($comment->isTopLevel())
        <div class="comments-nested">
            @foreach ($comment->nestedComments as $nestedComment)
                <livewire:comments-comment :comment="$nestedComment" :key="$nestedComment->id" />
            @endforeach
            @auth
                <div class="comments-form">
                    <x-comments::avatar :comment="$comment" />
                    <form class="comments-form-inner" wire:submit.prevent="reply">
                        <div
                            x-data="{ isExpanded: false }"
                            x-init="
                                $wire.on('reply-{{ $comment->id }}', () => {
                                    isExpanded = false;
                                });
                            "
                        >
                            <input
                                x-show="!isExpanded"
                                @click="isExpanded = true"
                                class="comments-placeholder"
                                placeholder="{{ __('comments::comments.write_reply') }}"
                            >
                            <template x-if="isExpanded">
                                <div>
                                    @include('comments::livewire.partials.editor', [
                                        'property' => 'replyText',
                                        'placeholder' => __('comments::comments.write_reply'),
                                    ])
                                    @error('replyText')
                                        <p class="comments-error">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <x-comments::button submit>
                                        {{ __('comments::comments.create_reply') }}
                                    </x-comments::button>
                                    <x-comments::button link @click="isExpanded = false">
                                        {{ __('comments::comments.cancel') }}
                                    </x-comments::button>
                                </div>
                            </template>
                        </div>
                    </form>
                </div>
            @endauth
        </div>
    @endif
</div>
