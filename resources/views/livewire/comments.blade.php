<section>
    <div class="divide-y divide-gray-200">
        @include('comments::livewire.partials.commentsTitle')
        <div class="py-6">
            <div class="space-y-8">
                @if ($comments->count())
                    @foreach($comments as $comment)
                        <livewire:comments-comment
                            :key="$comment->id"
                            :comment="$comment"
                        />
                    @endforeach
                    {{ $comments->links() }}
                @else
                    <p> {{ __('comments-livewire::comments.no_comments_yet') }}</p>
                @endif
            </div>
        </div>
    </div>
    @include('comments::livewire.partials.createComment')
</section>
