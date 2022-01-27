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

<style>
    .comment-header{
        display: flex;
        gap: 1rem;
        position: relative;
        z-index: 50;
        justify-content: space-between;
    }
    .comment-header-info{
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .comment-header-info>a{
        cursor: pointer;
    }

    .comment-header-info>a, .comment-header-info>span{
        font-weight: 500;
        color: rgb(17 24 39);
    }
    .comment-header-info>.devider{
        background-color: rgb(156 163 175);
        width: .25rem;
        height: .25rem;
        border-radius: 
    }

    .comment-header-info>.comment-date{
        color: rgb(156 163 175);
    }

    .comment-header-info>.comment-date:hover{
        text-decoration: underline;
    }
</style>
