<div x-cloak class="flex-grow gap-4 relative items-center" x-data="{ menuOpen: false, deleteConfirm: false }"
     x-on:click.outside="menuOpen = deleteConfirm = false">
    @unless($isEditing)
        <button type="button" x-on:click="menuOpen = !menuOpen"
                class="flex items-center float-right gap-2 hover:bg-gray-200  rounded-md cursor-pointer px-2 py-1">
            <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  " fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
            </svg>
            <svg x-show="menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="absolute w-48 bg-white rounded-md shadow-xl right-12">
            @can('update', $comment)
                <div x-show="menuOpen"
                     class="p-4 flex items-center gap-2  text-sm cursor-pointer rounded-md hover:bg-gray-200"
                     wire:click="startEditing">
                    @include('comments::livewire.svgs.edit')
                    {{  __('comments-livewire::comments.edit') }}
                </div>
            @endcan

            <div x-show="menuOpen"
                 class="p-4 flex items-center gap-2  text-sm cursor-pointer rounded-md hover:bg-gray-200"
                 x-on:click="menuOpen=false;navigator.clipboard.writeText(window.location.href.split('#')[0] + '#comment-{{ $comment->id }}')">
                @include('comments::livewire.svgs.edit')

                {{  __('comments-livewire::comments.copy_link') }}
            </div>

            @can('delete', $comment)
                <div x-show="menuOpen"
                     class="p-4 flex gap-2 items-center  text-sm relative cursor-pointer rounded-md hover:bg-gray-200"
                     x-on:click.outside="deleteConfirm = false" x-on:click="deleteConfirm = !deleteConfirm">

                    @include('comments::livewire.svgs.delete')

                    {{ __('comments-livewire::comments.delete') }}
                    <div x-show="deleteConfirm"
                         class="absolute z-40 w-64 bg-white shadow-lg mt-4 rounded-md top-0 transform translate-y-4 right-0">
                        <div
                            class="w-5  inline-block absolute right-0 transform -translate-x-1/4 -translate-y-full">
                            <div class=" h-3 w-3 bg-white rotate-45 rounded-tl-md transform origin-bottom-left">
                            </div>
                        </div>
                        <div class=" normal-case p-4 ">
                            <p class="font-bold text-lg">
                                {{ __('comments-livewire::comments.delete_confirmation_title') }}
                            </p>
                            <p class="mb-4">
                                {{ __('comments-livewire::comments.delete_confirmation_text') }}
                            </p>
                            <button type="button"
                                    class="text-white flex items-center float-right mb-2 gap-2  rounded-md bg-rose-600 px-4 py-2"
                                    wire:click="deleteComment">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5  w-5 stroke-wite" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                {{ __('comments-livewire::comments.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    @endunless
</div>
