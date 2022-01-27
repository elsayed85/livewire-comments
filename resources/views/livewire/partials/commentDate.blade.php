<span class="comment-date">
    <a href="#comment-{{ $comment->id }}">
        @if($comment->created_at->diffInMinutes() < 1)
            {{ __('comments-livewire::comments.just_now') }}
        @else
            {{ $comment->created_at->diffForHumans() }}
        @endif
    </a>
</span>
