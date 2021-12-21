<div x-cloak class="p-1 z-30 relative cursor-pointer rounded-md hover:bg-gray-200"
     x-data="{ open: false }"
     x-on:click.outside="open = false">
    @auth
        <svg x-on:click="open = !open" xmlns="http://www.w3.org/2000/svg"
             class="h-5  w-5 stroke-gray-700"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div x-show="open"
             class="absolute  bg-white shadow-lg  rounded-md left-full top-0 transform translate-x-4">


            @can('react', $comment)
                <div x-on:click="open = !open" class=" px-1 py-1  grid gap-1 grid-cols-5 w-56  ">

                    @foreach(config('comments.allowed_reactions') as $reaction)


                        @php
                            $userReacted = !is_bool(array_search($reaction, array_column($comment->reactions()->get()->toArray(), 'reaction')))
                        @endphp

                        <div
                            class="border-1 text-center col-span-1 hover:bg-gray-100 p-2 rounded-md cursor-pointer  @if($userReacted) bg-{!! $primaryColor !!} hover:bg-{!! $primaryColor !!} bg-opacity-25 hover:bg-opacity-50 @endif"
                            @if($userReacted)
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
