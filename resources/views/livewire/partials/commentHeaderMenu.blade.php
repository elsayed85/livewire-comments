<div x-cloak class="comment-options " x-data="{ menuOpen: false, deleteConfirm: false }"
     x-on:click.outside="menuOpen = deleteConfirm = false">
    @unless($isEditing)
        <button type="button" x-on:click="menuOpen = !menuOpen">
            <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg"  fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
            </svg>
            <svg x-show="menuOpen" xmlns="http://www.w3.org/2000/svg"  fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="comment-options-body">
            @can('update', $comment)
                <div x-show="menuOpen"
                     class="update-button"
                     wire:click="startEditing">
                    @include('comments::livewire.svgs.edit')
                    {{  __('comments-livewire::comments.edit') }}
                </div>
            @endcan

            <div x-show="menuOpen"
                 class="copy-button"
                 x-on:click="menuOpen=false;navigator.clipboard.writeText(window.location.href.split('#')[0] + '#comment-{{ $comment->id }}')">
                @include('comments::livewire.svgs.copy')

                {{  __('comments-livewire::comments.copy_link') }}
            </div>

            @can('delete', $comment)
                <div x-show="menuOpen"
                     class="delete-button"
                     x-on:click.outside="deleteConfirm = false" x-on:click="deleteConfirm = !deleteConfirm">

                    @include('comments::livewire.svgs.delete')

                    {{ __('comments-livewire::comments.delete') }}
                    <div x-show="deleteConfirm"
                         class="delete-confirmation">
                        <div >
                            <p class="title">
                                {{ __('comments-livewire::comments.delete_confirmation_title') }}
                            </p>
                            <p class="body ">
                                {{ __('comments-livewire::comments.delete_confirmation_text') }}
                            </p>
                            <button type="button"
                                    class="delete-button "
                                    wire:click="deleteComment">
                                <svg xmlns="http://www.w3.org/2000/svg"  fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                {{ __('comments-livewire::comments.delete') }}
                            </button>
                        </div>
                    </div>
                </div>

                @include('comments::livewire.partials.extraCommentHeaderMenuItems')
            @endcan
        </div>
    @endunless
</div>
