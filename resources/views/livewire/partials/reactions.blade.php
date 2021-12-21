<div class="my-4 relative  flex items-center space-x-4">

    @foreach($comment->reactions->summary() as $summary)
        <div wire:click="deleteReaction('{{ $summary['reaction'] }}')"
             class="rounded-full cursor-pointer hover:bg-gray-300 bg-gray-200 py-1 px-2 text-sm @if($summary['user_reacted']) border border-{!! $primaryColor !!} bg-{!! $primaryColor !!} bg-opacity-25 hover:bg-opacity-50 @endif">
            {{ $summary['reaction'] }} {{ $summary['count'] }}
        </div>
    @endforeach

    @include('comments::livewire.partials.reactionPicker')
</div>
