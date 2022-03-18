<div class="comment-header">
    <div class="comment-header-info ">
        @if($url = $comment->commentatorProperties()->url)
            <a href="{{ $url }}" >{{ $comment->commentatorProperties()->name }}</a>
        @else
            <span class="">{{ $comment->commentatorProperties()->name }}</span>
        @endif
        <div class="devider "></div>
        @include('comments::livewire.partials.commentDate')
    </div>

    @include('comments::livewire.partials.commentHeaderMenu')
</div>
