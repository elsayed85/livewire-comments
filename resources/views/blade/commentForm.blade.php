<form wire:submit.prevent="{{ $submitMethod }}">
    <div>
        <label for="comment" class="sr-only">Comment body</label>
        <textarea id="comment" name="comment" rows="3" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md @error($fieldName) border-red-500 @enderror" placeholder="Write something" wire:model.defer="{{ $fieldName }}"></textarea>

        @error($fieldName)
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <div class="mt-3 flex items-center justify-between">
        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Comment
        </button>
    </div>
</form>
