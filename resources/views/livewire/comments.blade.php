<section class="comments">
    <header class="comments-header">
        <p><strong>Comments</strong></p>
        @if(config('comments.notifications.enabled'))
            @auth
                <x-comments::toggle wire:model="sendNotifications">
                    {{ __('comments::comments.send_notifications') }}
                </x-comments::toggle>
            @endauth
        @endif
    </header>
    @if($comments->count())
        @foreach($comments as $comment)
            <livewire:comments-comment :key="$comment->id" :comment="$comment" />
        @endforeach
        {{ $comments->links() }}
    @else
        <p>{{ __('comments::comments.no_comments_yet') }}</p>
    @endif
    @can('createComment', $model)
        <div class="comments-form">
            <x-comments::avatar />
            <form class="comments-form-inner" wire:submit.prevent="comment">
                <x-dynamic-component
                    :component="config('comments.editor')"
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
</section>
