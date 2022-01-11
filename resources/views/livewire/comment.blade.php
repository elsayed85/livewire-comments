<div
    id="comment{{ $comment->id }}"
    @class(["bg-white border-b border-gray-300 pb-8"=> $comment->isTopLevel()])
>
    <div class="flex p-4 pb-0 group rounded-md">
        <div @class(["flex-shrink-0 mr-4", "mt-4"=> !$comment->isTopLevel()])>
            @include('comments::livewire.partials.avatar')
        </div>

        <div @class(['flex-grow', 'border p-4 rounded-md border-gray-300'=> !$comment->isTopLevel()])>
            @include('comments::livewire.partials.commentHeader')

            <div class="mt-1 flex-grow w-full markdown @if($comment->isTopLevel()) toplevel-markdown @endif">
                @if ($isEditing)
                    <form wire:submit.prevent="edit">
                        <div x-data="compose({ text: @entangle('editText') })">
                            <div wire:ignore>
                                <textarea placeholder="{{ trans('comments-livewire::comments.write_comment') }}">{{ $editText }}</textarea>
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
                                {{ trans('comments-livewire::comments.edit_comment') }}
                            </button>
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                {{ trans('comments-livewire::comments.cancel') }}
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
                                        placeholder="{{ trans('comments-livewire::comments.write_reply') }}"
                                    >
                                    <div x-show="isExpanded" wire:ignore>
                                        <textarea placeholder="{{ trans('comments-livewire::comments.write_reply') }}">{{ $replyText }}</textarea>
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
                                        {{ trans('comments-livewire::comments.create_reply') }}
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
