<section class="comments">
    <header class="comments-header">
        <p><strong>Comments</strong></p>
        @if(config('comments.notifications.enabled'))
            @auth
                <x-comments::toggle wire:model="sendNotifications">
                    {{ __('comments-livewire::comments.send_notifications') }}
                </x-comments::toggle>
            @endauth
        @endif
    </header>
    @if($comments->count())
        @foreach($comments as $comment)
            <livewire:comments-comment
                :key="$comment->id"
                :comment="$comment"
            />
        @endforeach
        {{ $comments->links() }}
    @else
        <p>{{ __('comments-livewire::comments.no_comments_yet') }}</p>
    @endif
</section>
