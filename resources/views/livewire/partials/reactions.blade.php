<div class="reactions ">

    @foreach($comment->reactions->summary() as $summary)
    <div wire:click="deleteReaction('{{ $summary['reaction'] }}')"
        class="@if($summary['commentator_reacted']) reacted @endif">
        {{ $summary['reaction'] }} {{ $summary['count'] }}
    </div>
    @endforeach

    @include('comments::livewire.partials.reactionPicker')
</div>
