<x-comments::dropdown>
    <div x-show="dropdownOpen" class="comments-dropdown-body">
        @can('update', $comment)
            <x-comments::dropdown.item
                icon="edit"
                @click="startEditing"
            >
                {{  __('comments-livewire::comments.edit') }}
            </x-comments::dropdown.item>
        @endcan
        <x-comments::dropdown.item
            icon="copy"
            @click="dropdownOpen = false;navigator.clipboard.writeText(window.location.href.split('#')[0] + '#comment-{{ $comment->id }}')"
        >
            {{  __('comments-livewire::comments.copy_link') }}
        </x-comments::dropdown.item>
        @can('delete', $comment)
            <x-comments::dropdown.item
                icon="delete"
                @click="deleteConfirm = !deleteConfirm"
                @click.outside="deleteConfirm = false"
            >
                {{ __('comments-livewire::comments.delete') }}
            </x-comments::dropdown.item>
            <!-- @todo Extract to modal component -->
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
                            @click="deleteComment">
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('comments-livewire::comments.delete') }}
                    </button>
                </div>
            </div>
        @endcan
        @include('comments::livewire.partials.extraCommentHeaderMenuItems')
    </div>
</x-comments::dropdown>
