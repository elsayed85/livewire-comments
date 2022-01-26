<div class="flex gap-4 relative z-50 justify-between">
    <div class="flex gap-4 items-center">
        @if($url = $comment->commentatorProperties()->url)
            <a href="{{ $url }}" class="font-medium text-gray-900">{{ $comment->commentatorProperties()->name }}</a>
        @else
            <span class="font-medium text-gray-900">{{ $comment->commentatorProperties()->name }}</span>
        @endif
        <div class="bg-gray-400 w-1 h-1 rounded-full"></div>
        @include('comments::livewire.partials.commentDate')
    </div>

    @include('comments::livewire.partials.commentHeaderMenu')
</div>
