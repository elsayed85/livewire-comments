@php
    use Spatie\Comments\Enums\NotificationSubscriptionType;
@endphp

<section class="comments {{ $newestFirst ? 'comments-newest-first' : '' }}">
    <header class="comments-header">
        @if($writable)
            @auth
                @if($showNotificationOptions)
                    <div class="comments-subscription">
                        <x-comments::dropdown>
                            <x-slot name="trigger">
                                <span class="comments-subscription-trigger">
                                    Send notifications:
                                    <span class="comments-subscription-current">{{ $selectedNotificationSubscriptionType }}</span>
                                </span>
                            </x-slot>

                            @foreach(NotificationSubscriptionType::cases() as $case)
                                <x-comments::dropdown.item @click="dropdownOpen = false" wire:click="updateSelectedNotificationSubscriptionType('{{ $case->value }}')">
                                    {{ $case->description() }}
                                </x-comments::dropdown.item>
                            @endforeach
                        </x-comments::dropdown>
                    </div>
                @endif
            @endif
        @endauth
    </header>

    @if ($newestFirst)
        @include('comments::livewire.partials.newComment')
    @endif

    @if($comments->count())
        @foreach($comments as $comment)
            @can('see', $comment)
                <livewire:comments-comment
                    :key="$comment->id"
                    :comment="$comment"
                    :show-avatar="$showAvatars"
                    :newest-first="$newestFirst"
                    :writable="$writable"
                    :show-replies="$showReplies"
                />
            @endcan
        @endforeach
        {{ $comments->links() }}
    @else
        <p class="comments-no-comment-yet">{{ $this->noCommentsText ?? __('comments::comments.no_comments_yet') }}</p>
    @endif

    @if (! $this->newestFirst)
        @include('comments::livewire.partials.newComment')
    @endif
</section>
