<div class="reactions ">

    @foreach($comment->reactions->summary() as $summary)
    <div wire:click="deleteReaction('{{ $summary['reaction'] }}')"
        class="@if($summary['commentator_reacted']) reacted @endif">
        {{ $summary['reaction'] }} {{ $summary['count'] }}
    </div>
    @endforeach

    @include('comments::livewire.partials.reactionPicker')
</div>

<style>
    .reactions {
        position: relative;
        display: flex;
        align-items: center;
        margin: 1rem 0;
    }

    .reactions> :not([hidden])~ :not([hidden]) {
        margin-left: 1rem;
    }

    .reactions>div {
        border-radius: 99999px;
        cursor: pointer;
        background-color: rgb(229 231 235);
        padding: .25rem .5rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        rounded-full cursor-pointer hover: bg-gray-300 bg-gray-200 py-1 px-2 text-sm
    }

    .reactions>div:hover{
        background-color: rgb(209 213 219);
    }
    .reactions>div.reacted{
        border: 1px solid #4338ca;
        background-color: rgba(67, 56, 202, .25);
    }

    .reactions>div.reacted:hover{
        background-color: rgba(67, 56, 202, .5);
    }
</style>