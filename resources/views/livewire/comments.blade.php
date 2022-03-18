<section>
    <div class="comments-wrapper">
        @include('comments::livewire.partials.commentsTitle')
        <div class="comments-body">
            <div>
                @if ($comments->count())
                    @foreach($comments as $comment)
                        <livewire:comments-comment :key="$comment->id" :comment="$comment" />
                    @endforeach
                    {{ $comments->links() }}
                @else
                    <p> {{ __('comments-livewire::comments.no_comments_yet') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
