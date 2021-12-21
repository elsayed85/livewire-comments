<div class="flex gap-4 relative z-50 justify-between">
    <div class="flex gap-4 items-center">
        <a href="#" class="font-medium text-gray-900">{{ $comment->user->name }}</a>
        <div class="bg-gray-400 w-1 h-1 rounded-full"></div>
        <span class="text-gray-400 ">
            {{ $comment->created_at->diffForHumans() }}
        </span>
    </div>

    @include('comments::livewire.partials.commentHeaderMenu')
</div>
