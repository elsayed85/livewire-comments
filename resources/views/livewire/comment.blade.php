<div
    id="comment{{ $comment->id }}"
    @class(["bg-white border-b border-gray-300 pb-8"=> $comment->isTopLevel()])
>
    <div class="flex p-4 pb-0 group rounded-md" )>
        <div @class(["flex-shrink-0 mr-4", "mt-4"=> !$comment->isTopLevel()])>
            @include('comments::livewire.partials.avatar')
        </div>

        <div @class(['flex-grow', 'border p-4 rounded-md border-gray-300'=> !$comment->isTopLevel()])>
            @include('comments::livewire.partials.commentHeader')

            <div class="mt-1 flex-grow w-full markdown @if($comment->isTopLevel()) toplevel-markdown @endif">
                @if ($isEditing)
                    <livewire:comments-compose
                        :on-submit="'edit:' . $comment->id"
                        :on-cancel="'cancel:' . $comment->id"
                        :text="$comment->original_text"
                        :primary-color="$primaryColor"
                        auto-focus
                    />
                @else
                    <p class=" text-gray-700">{!! $comment->text !!}</p>
                @endif
            </div>

            @include('comments::livewire.partials.reactions')
        </div>
    </div>

    <div class="ml-[4.5rem] mt-6 relative">
        @foreach ($comment->nestedComments as $nestedComment)
            <livewire:comments-comment
                :comment="$nestedComment"
                :key="$nestedComment->id"
                :primary-color="$primaryColor"
            />
        @endforeach

        <div id="reply-form-{{ $comment->id }}">
            @if ($isReplying)
                <livewire:comments-compose
                    :on-submit="'reply:'  . $comment->id"
                    :on-cancel="'cancel:' . $comment->id"
                    :primary-color="$primaryColor"
                    placeholder="Leave a reply"
                    auto-focus
                />
            @endif
        </div>

        @if (!$isReplying)
            @if ($comment->isTopLevel())
                @auth
                    <div class="flex border border-gray-300 p-4 rounded-md">
                        <div class="flex-shrink-0 mr-4">
                            @include('comments::livewire.partials.avatar')
                        </div>
                        <input
                            wire:click="$toggle('isReplying')" class="w-full border border-gray-300 rounded-md px-4"
                            type="text"
                            placeholder="{{ trans('comments-livewire::comments.write_reply') }}"
                        />
                    </div>
                @endauth
            @endif
        @endif
    </div>
</div>
