<span class="text-gray-400 hover:underline">
    <a href="#comment-{{ $comment->id }}">
        @if($comment->created_at->diffInMinutes() < 1)
            {{ __('comments-livewire::comments.just_now') }}
        @else
            {{ $comment->created_at->diffForHumans() }}
        @endif
    </a>
</span>
