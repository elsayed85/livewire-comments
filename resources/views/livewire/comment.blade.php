<div
    id="comment{{ $comment->id }}"
    @class(["comment-top-level"=> $comment->isTopLevel()])
>
    <div class="comment-wrapper">
        <div @class(["avatar", "top-level"=> $comment->isTopLevel()])>
            @include('comments::livewire.partials.avatar')
        </div>

        <div @class(['comment-body', 'top-level'=> $comment->isTopLevel()])>
            @include('comments::livewire.partials.commentHeader')

            <div class="mt-1 flex-grow w-full markdown @if($comment->isTopLevel()) toplevel-markdown @endif">
                @if ($isEditing)
                    <form wire:submit.prevent="edit">
                        <div x-data="compose({ text: @entangle('editText') })">
                            <div wire:ignore>
                                <textarea placeholder="{{ __('comments-livewire::comments.write_comment') }}">{{ $editText }}</textarea>
                            </div>
                        </div>
                        @error('editText')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="mt-3 flex items-center space-x-4">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-[#4338ca] hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                {{ __('comments-livewire::comments.edit_comment') }}
                            </button>
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                {{ __('comments-livewire::comments.cancel') }}
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-gray-700">{!! $comment->text !!}</div>
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
            />
        @endforeach
        @if($comment->isTopLevel())
            @auth
                <div id="reply-form-{{ $comment->id }}">
                    <form wire:submit.prevent="reply">
                        <div class="flex border border-gray-300 p-4 rounded-md">
                            <div class="flex-shrink-0 mr-4">
                                @include('comments::livewire.partials.avatar')
                            </div>
                            <div class="flex-1">
                                <div
                                    x-data="{ ...compose({ text: @entangle('replyText'), defer: true }), isExpanded: false }"
                                    x-init="
                                        $wire.on('reply-{{ $comment->id }}', () => {
                                            clear();
                                            isExpanded = false;
                                        });
                                        $watch('isExpanded', (isExpanded) => {
                                            if (isExpanded) {
                                                load();
                                            }
                                        });
                                    "
                                >
                                    <input
                                        x-show="!isExpanded"
                                        @click="isExpanded = true"
                                        class="w-full border border-gray-300 rounded-md p-4"
                                        placeholder="{{ __('comments-livewire::comments.write_reply') }}"
                                    >
                                    <div x-show="isExpanded" wire:ignore>
                                        <textarea placeholder="{{ __('comments-livewire::comments.write_reply') }}">{{ $replyText }}</textarea>
                                    </div>
                                </div>
                                @error('replyText')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="mt-3 flex items-center space-x-4">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-[#4338ca] hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        {{ __('comments-livewire::comments.create_reply') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth
        @endif
    </div>
</div>

<style>
    .comment-top-level{
        background-color:white;
        border-bottom: 1px solid rgb(209 213 219);
        padding-bottom: 2rem;
    }

    .comment-wrapper{
        display: flex;
        padding: 1rem;
        padding-bottom: 0;
        border-radius: 0.375rem;
    }

    .avatar{
        flex-shrink: 0;
        margin-right: 1rem;
        margin-top:1rem;
    }

    .avatar img{
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 99999px
    }

    .avatar.top-level{
        margin-top: 0rem;
    }

    .comment-body{
        flex-grow: 1;
        padding: 1rem;
        border: 1px solid rgb(209 213 219);
        border-radius: 0.375rem;
    }

    .comment-body.top-level{
        padding: 0;
        border:none;
    }
</style>
