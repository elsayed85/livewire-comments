@php
    use Spatie\Comments\Enums\NotificationSubscriptionType;
@endphp

<section class="comments">
    @if ($this->newestFirst)
        @include('comments::components.forms.newComment')
    @endif

    <header class="comments-header">
        @if($writable)
            <p><strong></strong></p>
            @auth
                @if($showNotificationOptions)
                    <div>
                        <span>
                        Send notifications:
                        </span>

                        <select wire:model="selectedNotificationSubscriptionType">
                            @foreach(NotificationSubscriptionType::cases() as $case)
                                <option
                                    value="{{ $case->value }}">
                                    {{ strtolower($case->description()) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
