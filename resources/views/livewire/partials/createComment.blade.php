@can('createComment', $model)
    <div class="bg-gray-50 px-4 py-6 sm:px-6">
        @auth
            <div class="flex">
                <div class="flex-shrink-0 mr-4">
                    @include('comments::livewire.partials.avatar')
                </div>
                <div class="min-w-0 flex-1">
                    <form wire:submit.prevent="comment">
                        <div x-data="compose({ text: @entangle('text') })" x-init="$wire.on('comment', clear)">
                            <div wire:ignore>
                                <textarea placeholder="{{ __('comments-livewire::comments.write_comment') }}">{{ $text }}</textarea>
                            </div>
                        </div>
                        @error('text')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="mt-3 flex items-center space-x-4">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-[#4338ca] hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                {{ __('comments-livewire::comments.create_comment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <p>Log in to comment</p>
        @endauth
    </div>
@endcan
