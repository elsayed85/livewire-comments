<div
    id="comment-{{ $comment->id }}"
    class="comments-group"
    x-data="{ confirmDelete: false }"
>
    <div class="comments-comment">

        @if($showAvatar)
            <x-comments::avatar :comment="$comment"/>
        @endif

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
                    <x-comments::date :date="$comment->created_at"/>
                </a>

                @unless($isEditing)
                    @if($writable)
                        <x-comments::dropdown>
                            @can('update', $comment)
                                <x-comments::dropdown.item
                                    wire:click="startEditing"
                                >
                                    {{  __('comments::comments.edit') }}
                                </x-comments::dropdown.item>
                            @endcan
                            <x-comments::dropdown.item
                                @click="closeDropdown(); navigator.clipboard.writeText(window.location.href.split('#')[0] + '#comment-{{ $comment->id }}')"
                            >
                                {{  __('comments::comments.copy_link') }}
                            </x-comments::dropdown.item>
                            @can('delete', $comment)
                                <x-comments::dropdown.item class="danger"
                                                           @click="confirmDelete = true; dropdownOpen = false"
                                >
                                    {{ __('comments::comments.delete') }}
                                </x-comments::dropdown.item>
                            @endcan
                            @include('comments::extraCommentHeaderMenuItems')
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
                    @endif
                @endunless
            </div>

            @if($comment->isPending())
                <div class="comments-info-message">This is a pending comment that is awaiting approval</div>

                @can('reject', $comment)
                    <button
                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded bg-red-200"
                        wire:click="reject">
                        Reject
                    </button>
                @endcan

                @can('approve', $comment)
                    <button
                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded bg-green-200"
                        wire:click="approve">
                        Approve
                    </button>
                @endcan


            @endif

            @if($isEditing)
                <div class="comments-form">
                    <form class="comments-form-inner" wire:submit.prevent="edit">
                        <x-dynamic-component
                            :component="\Spatie\LivewireComments\Support\Config::editor()"
                            model="editText"
                            :comment="$comment"
                            autofocus
                        />
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
                            wire:key="{{ $comment->id }}{{$summary['reaction']}}"
                            @auth
                            wire:click="toggleReaction('{{ $summary['reaction'] }}')"
                            @endauth
                            @class(['comments-reaction', 'is-reacted' => $summary['commentator_reacted']])
                        >
                            {{ $summary['reaction'] }} {{ $summary['count'] }}
                        </div>
                    @endforeach
                    @if($writable)
                        <div
                            x-cloak
                            x-data="{ open: false }"
                            @click.outside="open = false"
                            class="comments-reaction-picker"
                        >

                            @can('react', $comment)
                                <button class="comments-reaction-picker-trigger" type="button" @click="open = !open">
                                    <x-comments::icons.smile/>
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
                                                wire:click="toggleReaction('{{ $reaction }}')"
                                            >
                                                {{ $reaction }}
                                            </button>
                                        @endforeach
                                    </div>
                                </x-comments::modal>
                            @endcan
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
    @if($showReplies)
        @if($comment->isTopLevel())
            <div class="comments-nested">
                @if($this->newestFirst)
                    @auth
                        @include('comments::livewire.partials.replyTo')
                    @endauth
                @endif

                @foreach ($comment->nestedComments as $nestedComment)
                    @can('see', $nestedComment)
                        <livewire:comments-comment
                            :key="$nestedComment->id"
                            :comment="$nestedComment"
                            :show-avatar="$showAvatar"
                            :newest-first="$newestFirst"
                            :writable="$writable"
                        />
                    @endcan
                @endforeach

                @if(! $this->newestFirst)
                    @auth
                        @include('comments::livewire.partials.replyTo')
                    @endauth
                @endif
            </div>
        @endif
    @endif
</div>
