<div id="comment{{ $comment->id }}" @class(["bg-white border-b border-gray-300 pb-8"=> $comment->isTopLevel()])>


    <div class=' flex p-4 pb-0 group rounded-md' ])>

        <div @class(["flex-shrink-0 mr-4", "mt-4"=> !$comment->isTopLevel()])>
            <img class="h-10 w-10 rounded-full" src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50"
                alt="{{ $comment->user->name }}">
        </div>

        <div @class(['flex-grow', 'border p-4 rounded-md border-gray-300'=> !$comment->isTopLevel()])>
            <div class="flex gap-4  justify-between">
                <div class="flex gap-4 items-center">
                    <a href="#" class="font-medium text-gray-900">{{ $comment->user->name }}</a>
                    <div class="bg-gray-400 w-1 h-1 rounded-full"></div>
                    <span class="text-gray-400 ">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>
                <div class="flex-grow gap-4 relative items-center" x-data="{ menuOpen: false, deleteConfirm: false }"
                    x-on:click.outside="menuOpen = deleteConfirm = false">
                    @unless($isEditing)


                    <button type="button" x-on:click="menuOpen = !menuOpen"
                        class="flex items-center float-right gap-2 hover:bg-gray-200  rounded-md cursor-pointer px-2 py-1">
                        <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  " fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                        <svg x-show="menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="absolute w-48 bg-white rounded-md shadow-xl right-12">
                        @can('update', $comment)
                        <div x-show="menuOpen"
                            class="p-4 flex items-center gap-2 uppercase text-sm cursor-pointer rounded-md hover:bg-gray-200"
                            wire:click="startEditing">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5  w-5 stroke-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            edit
                        </div>
                        @endcan
                        @can('delete', $comment)
                        <div x-show="menuOpen"
                            class="p-4 flex gap-2 items-center uppercase text-sm relative cursor-pointer rounded-md hover:bg-gray-200"
                            x-on:click.outside="deleteConfirm = false" x-on:click="deleteConfirm = !deleteConfirm">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5  w-5 stroke-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            delete
                            <div x-show="deleteConfirm"
                                class="absolute z-50 w-64 bg-white shadow-lg mt-4 rounded-md top-0 transform translate-y-4 right-0">
                                <div
                                    class="w-5  inline-block absolute right-0 transform -translate-x-1/4 -translate-y-full">
                                    <div class=" h-3 w-3 bg-white rotate-45 rounded-tl-md transform origin-bottom-left">
                                    </div>
                                </div>
                                <div class=" normal-case p-4 ">
                                    <p class="font-bold text-lg">Delete Comment</p>
                                    <p class="mb-4">Are you sure? This can not be undone.</p>
                                    <button type="button"
                                        class="text-white flex items-center float-right mb-2 gap-2  rounded-md bg-rose-600 px-4 py-2"
                                        wire:click="deleteComment">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5  w-5 stroke-wite" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endcan

                    </div>

                    @endunless


                </div>


            </div>
            <div class="mt-1 flex-grow w-full markdown @if($comment->isTopLevel()) toplevel-markdown @endif">
                @if ($isEditing)
                <livewire:comments-compose :on-submit="'edit:' . $comment->id" :on-cancel="'cancel:' . $comment->id"
                    :text="$comment->original_text" :primaryColor="$primaryColor" />
                @else
                <p class=" text-gray-700">{!! $comment->text !!}</p>
                @endif
            </div>

            <div class="my-4 relative  flex items-center space-x-4">

                @foreach($comment->reactions->summary() as $summary)
                <div wire:click="deleteReaction('{{ $summary['reaction'] }}')"
                    class="rounded-full cursor-pointer hover:bg-gray-300 bg-gray-200 py-1 px-2 text-sm @if($summary['user_reacted']) border border-{!! $primaryColor !!} bg-{!! $primaryColor !!} bg-opacity-25 hover:bg-opacity-50 @endif">
                    {{ $summary['reaction'] }} {{ $summary['count'] }}
                </div>
                @endforeach

                
                

                <div class="p-1 z-40 relative cursor-pointer rounded-md hover:bg-gray-200" x-data="{ open: false }"
                    x-on:click.outside="open = false">
                    @auth
                    <svg x-on:click="open = !open" xmlns="http://www.w3.org/2000/svg" class="h-5  w-5 stroke-gray-700"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div x-show="open"
                        class="absolute  bg-white shadow-lg  rounded-md left-full top-0 transform translate-x-4">


                        @can('react', $comment)
                        <div x-on:click="open = !open" class=" px-1 py-1  grid gap-1 grid-cols-5 w-56  ">

                            @foreach(config('comments.allowed_reactions') as $reaction)


                            @php
                                $userReacted = !is_bool(array_search($reaction, array_column($comment->reactions()->get()->toArray(), 'reaction')))
                            @endphp

                            <div class="border-1 text-center col-span-1 hover:bg-gray-100 p-2 rounded-md cursor-pointer  @if($userReacted) bg-{!! $primaryColor !!} hover:bg-{!! $primaryColor !!} bg-opacity-25 hover:bg-opacity-50 @endif"
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



            </div>


        </div>
    </div>

    <div class="ml-[4.5rem] mt-6 relative">
        @foreach ($comment->nestedComments as $nestedComment)
        <livewire:comments-comment :comment="$nestedComment" :key="$nestedComment->id" :primaryColor="$primaryColor" />
        @endforeach

        <div id="reply-form-{{ $comment->id }}">
            @if ($isReplying)
            <livewire:comments-compose :on-submit="'reply:'  . $comment->id" :on-cancel="'cancel:' . $comment->id"
                :primaryColor="$primaryColor" />
            @endif
        </div>


        @if (!$isReplying)
        @if ($comment->isTopLevel())
        @auth
        <div class=" flex border border-gray-300 p-4 rounded-md">
            <div class="flex-shrink-0 mr-4">
                <img class="h-10 w-10 rounded-full"
                    src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50"
                    alt="{{ $comment->user->name }}">
            </div>
            <input wire:click="$toggle('isReplying')" class="w-full border border-gray-300 rounded-md px-4" type="text"
                placeholder="write reply">
        </div>
        @endauth
        @endif
        @endif
    </div>
</div>