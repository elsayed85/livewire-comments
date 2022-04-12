<section class="comments">
    @if ($this->newestFirst)
        @include('comments::components.forms.newComment')
    @endif

    <header class="comments-header">
        @if($writable)
            <p><strong></strong></p>
            @auth
                @if($showNotificationOptions)
                    <select wire:model="selectedNotificationSubscriptionType">
                        <option
                            value="{{ \Spatie\Comments\Enums\NotificationSubscriptionType::Participating->value  }}">
                            {{ \Spatie\Comments\Enums\NotificationSubscriptionType::Participating->value  }}
                        </option>
                        <option value="{{ \Spatie\Comments\Enums\NotificationSubscriptionType::All->value  }}">
                            {{ \Spatie\Comments\Enums\NotificationSubscriptionType::All->value  }}
                        </option>
                        <option value="{{ \Spatie\Comments\Enums\NotificationSubscriptionType::None->value  }}">
                            {{ \Spatie\Comments\Enums\NotificationSubscriptionType::None->value  }}
                        </option>
                    </select>
                @endif
            @endif
        @endauth
    </header>

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
        <p class="comment-no-comment-yet">{{ $this->noCommentsText ?? __('comments::comments.no_comments_yet') }}</p>
    @endif

    @if (! $this->newestFirst)
        @include('comments::components.forms.newComment')
    @endif
</section>
