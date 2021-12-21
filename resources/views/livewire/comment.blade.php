<div id="comment{{ $comment->id }}" @class(["bg-white border-b border-gray-300 pb-8"=> $comment->isTopLevel()])>

    <div class=' flex p-4 pb-0 group rounded-md' ])>
        <div @class(["flex-shrink-0 mr-4", "mt-4"=> !$comment->isTopLevel()])>
            @include('comments::livewire.partials.avatar')
        </div>

        <div @class(['flex-grow', 'border p-4 rounded-md border-gray-300'=> !$comment->isTopLevel()])>

            @include('comments::livewire.partials.commentHeader')

            <div class="mt-1 flex-grow w-full markdown @if($comment->isTopLevel()) toplevel-markdown @endif">
                @if ($isEditing)
                    <livewire:comments-compose :on-submit="'edit:' . $comment->id" :on-cancel="'cancel:' . $comment->id"
                                               :text="$comment->original_text" :primaryColor="$primaryColor"/>
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
            </div>
        </div>
    </div>

    <div class="ml-[4.5rem] mt-6 relative">
        @foreach ($comment->nestedComments as $nestedComment)
            <livewire:comments-comment :comment="$nestedComment" :key="$nestedComment->id"
                                       :primaryColor="$primaryColor"/>
        @endforeach

        <div id="reply-form-{{ $comment->id }}">
            @if ($isReplying)
                <livewire:comments-compose :on-submit="'reply:'  . $comment->id" :on-cancel="'cancel:' . $comment->id"
                                           :primaryColor="$primaryColor"/>
            @endif
        </div>


        @if (!$isReplying)
            @if ($comment->isTopLevel())
                @auth
                    <div class=" flex border border-gray-300 p-4 rounded-md">
                        <div class="flex-shrink-0 mr-4">
                            @include('comments::livewire.partials.avatar')
                        </div>
                        <input wire:click="$toggle('isReplying')" class="w-full border border-gray-300 rounded-md px-4"
                               type="text"
                               placeholder="Write reply">
                    </div>
                @endauth
            @endif
        @endif
    </div>
</div>
