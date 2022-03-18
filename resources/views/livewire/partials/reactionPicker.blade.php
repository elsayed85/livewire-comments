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
