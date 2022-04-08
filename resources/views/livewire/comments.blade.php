<section class="comments">
    <header class="comments-header">
        @if($writable)
            <p><strong></strong></p>
            @auth

                <select wire:model="selectedNotificationSubscriptionType">
                    <option value="{{ \Spatie\Comments\Enums\NotificationSubscriptionType::Participating->value  }}">
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
        @endauth
    </header>
    @if($comments->count())
        @foreach($comments as $comment)
            @can('see', $comment)
                <livewire:comments-comment
                    :key="$comment->id"
                    :comment="$comment"
                    :show-avatar="$showAvatars"
                    :writable="$writable"
                />
            @endcan
        @endforeach
        {{ $comments->links() }}
    @else
        <p class="comment-no-comment-yet">{{ __('comments::comments.no_comments_yet') }}</p>
    @endif

    @if ($writable)
        @can('createComment', $model)
            <div class="comments-form">
                @if($showAvatars)
                    <x-comments::avatar/>
                @endif
                <form class="comments-form-inner" wire:submit.prevent="comment">
                    <x-dynamic-component
                        :component="\Spatie\LivewireComments\Support\Config::editor()"
                        model="text"
                        :placeholder="__('comments::comments.write_comment')"
                    />
                    @error('text')
                    <p class="comments-error">
                        {{ $message }}
                    </p>
                    @enderror

                    <x-comments::button submit>
                        {{ __('comments::comments.create_comment') }}
                    </x-comments::button>
                </form>
            </div>
        @endcan
    @endif
</section>
