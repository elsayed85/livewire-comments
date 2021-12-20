<div>
    <div @class(['border border-gray-100'=> !$comment->isTopLevel(), 'bg-gray-50' => $comment->isTopLevel(), ' flex p-4
        pb-0 group rounded-md' ])>
        <div class="flex-shrink-0 mr-4">
            <img class="h-10 w-10 rounded-full" src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50"
                alt="{{ $comment->user->name }}">
        </div>
        <div class="flex-grow">
            <div class="flex gap-4 items-center">
                <a href="#" class="font-medium text-gray-900">{{ $comment->user->name }}</a>
                <div class="bg-gray-400 w-1 h-1 rounded-full"></div>
                <span class="text-gray-400 ">
                    {{ $comment->created_at->diffForHumans() }}
                </span>

                @can('update', $comment)
                <div class="p-1 flex items-center gap-2 uppercase text-sm cursor-pointer rounded-md hover:bg-gray-200"
                    wire:click="$toggle('isEditing')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5  w-5 stroke-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    edit
                </div>
                @endcan

                @can('delete', $comment)
                <div class="p-1 flex gap-2 items-center uppercase text-sm relative cursor-pointer rounded-md hover:bg-gray-200"
                    x-data="{ open: false }" x-on:click.outside="open = false">

                    <svg x-on:click="open = !open" xmlns="http://www.w3.org/2000/svg" class="h-5  w-5 stroke-gray-700"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    delete
                    <div x-show="open" class="absolute z-50 w-64 bg-white shadow-sm mt-4 rounded-md top-0 transform translate-y-4 right-0">
                        <div class="w-5  inline-block absolute right-0 transform -translate-x-1/4 -translate-y-full">
                            <div class=" h-3 w-3 bg-white rotate-45 rounded-tl-md transform origin-bottom-left">
                            </div>
                        </div>
                        <div class=" normal-case p-2 ">
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
            <div class="mt-1 flex-grow w-full">
                @if ($isEditing)
                <livewire:comments-compose :on-submit="'edit:' . $comment->id" :text="$comment->original_text" />
                @else
                <p class="text-gray-700">{!! $comment->text !!}</p>
                @endif
            </div>

            <div class="my-4 relative  flex items-center space-x-4">

                @foreach($comment->reactions->summary() as $summary)
                <div wire:click="deleteReaction('{{ $summary['reaction'] }}')"
                    class="@if($summary['user_reacted']) ? 'bg-blue-200' : '' @endif rounded-full cursor-pointer hover:bg-gray-300 bg-gray-200 py-1 px-2 text-sm">
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
                        class="absolute  bg-white shadow-sm mt-4 rounded-m left-1/2 transform -translate-x-1/2">
                        <div class="w-5  inline-block absolute left-1/2 transform -translate-x-1/2 -translate-y-full">
                            <div class=" h-3 w-3 bg-white rotate-45 rounded-tl-md transform origin-bottom-left">
                            </div>
                        </div>

                        @can('react', $comment)
                        <div class=" px-1 py-1  grid grid-cols-5 w-56  ">
                            @foreach(config('comments.allowed_reactions') as $reaction)
                            <div class="border-1 text-center col-span-1 hover:bg-gray-100 p-2 rounded-md cursor-pointer  border-red-600"
                                wire:click="react('{{ $reaction }}')">{{ $reaction
                                }}</div>
                            @endforeach
                        </div>
                        @endcan

                    </div>
                    @endauth
                </div>


                @auth
                @if ($comment->isTopLevel())
                <div
                    x-on:click="console.log('{{ $comment->id  }}'); document.getElementById('reply-form-{{ $comment->id }}').scrollIntoView({ behavior: 'smooth', block: 'end'});">
                    <button wire:click="$toggle('isReplying')" type="button"
                        class="text-gray-900 flex  rounded-md hover:bg-gray-200 p-1 border-gray-200 text-sm uppercase items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        Reply
                    </button>
                </div>

                @endif
                @endauth
            </div>


        </div>
    </div>

    <div class="ml-14 mt-6 relative">

        @foreach ($comment->nestedComments as $comment)
        <livewire:comments-comment :comment="$comment" :key="$comment->id" />
        @endforeach

        <div id="reply-form-{{ $comment->id }}">
            @if ($isReplying)
            <livewire:comments-compose :on-submit="'reply:' . $comment->id" />
        </div>
        @endif
    </div>
</div>