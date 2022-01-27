<div x-cloak class="reaction-picker"
     x-data="{ open: false }"
     x-on:click.outside="open = false">
    @auth
        <svg x-on:click="open = !open" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div x-show="open"
             class="reaction-picker-modal ">

            @can('react', $comment)
                <div x-on:click="open = !open">

                    @foreach(config('comments.allowed_reactions') as $reaction)
                        @php
                            $commentatorReacted = !is_bool(array_search($reaction, array_column($comment->reactions()->get()->toArray(), 'reaction')))
                        @endphp

                        <div
                            class="reaction-emoticon @if($commentatorReacted) reacted  @endif"
                            @if($commentatorReacted)
                            wire:click="deleteReaction('{{ $reaction }}')"
                            @else
                            wire:click="react('{{ $reaction }}')"
                            @endif
                        >
                            {{ $reaction }}
                        </div>
                    @endforeach
                </div>
            @endcan
        </div>
    @endauth
</div>

<style>
    .reaction-picker{
        padding: .25rem;
        z-index: 30;
        position: relative;
        cursor: pointer;
        border-radius: .375rem;
    }

    .reaction-picker > svg{
        height: 1.25rem;
        width: 1.25rem;
        stroke: #374151;
    }
    .reaction-picker:hover{
        background-color: rgb(229 231 235);
    }

    .reaction-picker-modal{
        background-color: white;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        border-radius: .375rem;
        position: absolute;
        left: 100%;
        top: 0;
        transform: translateX(1rem);
    }

    .reaction-picker-modal> div{
        padding: .25rem;
        display: grid;
        gap: .25rem;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        width: 14rem;
    }

    .reaction-picker-modal .reaction-emoticon{
        border: 1px solid rgba(243 244 246,0);;
        text-align: center;
        grid-column: span 1 / span 1;
        padding: .5rem;
        border-radius: .375rem;
        cursor: pointer;
    }
    .reaction-picker-modal .reaction-emoticon:hover{
        background-color: rgb(243 244 246);
    }

    .reaction-picker-modal .reaction-emoticon.reacted{
        background-color: rgba(67, 56, 202, .25)
    }

    .reaction-picker-modal .reaction-emoticon.reacted:hover{
        background-color: rgba(67, 56, 202, .5)

    }



</style>
