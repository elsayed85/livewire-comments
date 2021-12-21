<form wire:submit.prevent="submit" x-data="compose">
    <div wire:ignore>
        <textarea x-ref="editor">{{ $text }}</textarea>
    </div>
    <input type="hidden" x-ref="input" wire:model.defer="text">
    @error('text')
        <p class="mt-2 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror
    <div class="mt-3 flex items-center space-x-4">
        <button type="submit"
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-{{ $primaryColor }} hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
            Comment
            
        </button>
        @isset($onCancel)
            <button type="button" wire:click="cancel">
                Cancel
            </button>
        @endisset
    </div>
</form>
