<div>
    <div class="flex">
        <div class="flex-shrink-0 mr-4">
            <img class="h-10 w-10 rounded-full" src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50"
                 alt="{{ $comment->user->name }}">
        </div>
        <div class="flex-grow">
            <div>
                <a href="#" class="font-medium text-gray-900">{{ $comment->user->name }}</a>
            </div>
            <div class="mt-1 flex-grow w-full">
                @if ($isEditing)
                    <x-comments-form
                        submitMethod="editComment"
                        fieldName="editCommentText"
                    />
                @else
                    <p class="text-gray-700">{!! $comment->text !!}</p>
                @endif
            </div>
            <div class="mt-2 space-x-2">
        <span class="text-gray-500 font-medium">
          {{ $comment->created_at->diffForHumans() }}
        </span>
                @auth
                    @if ($comment->isTopLevel())
                        <button wire:click="$toggle('isReplying')" type="button" class="text-gray-900 font-medium">
                            Reply
                        </button>
                    @endif

                    @can('update', $comment)
                        <button wire:click="$toggle('isEditing')" type="button" class="text-gray-900 font-medium">
                            Edit
                        </button>
                    @endcan

                    {{-- @can('destroy', $comment)  --}}
                    <button
                        type="button"
                        class="text-gray-900 font-medium"
                        wire:click="deleteComment"
                    >
                        Delete
                    </button>
                    {{-- @endcan --}}
                @endauth
            </div>

            <div class="my-4 flex space-x-8">
                @foreach($comment->reactions->summary() as $summary)
                    <div wire:click="removeReaction('{{ $summary['reaction'] }}')"
                         class="@if($summary['current_user_reacted']) ? 'bg-blue-200' : '' @endif">
                        {{ $summary['reaction'] }} {{ $summary['count'] }}
                    </div>
                @endforeach
            </div>

            @auth
                <div class="my-4 flex space-x-8">
                    @foreach(config('comments.allowed_reactions') as $reaction)
                        <div class="border-1 border-red-600" wire:click="react('{{ $reaction }}')">{{ $reaction }}</div>
                    @endforeach
                </div>
            @endauth
        </div>
    </div>

    <div class="ml-14 mt-6">
        @if ($isReplying)
            <x-comments-form
                submitMethod="postReply"
                fieldName="replyCommentText"
            />
        @endif

        @foreach ($comment->nestedComments as $comment)
            <livewire:comment :comment="$comment" :key="$comment->id"/>
        @endforeach
    </div>
</div>
