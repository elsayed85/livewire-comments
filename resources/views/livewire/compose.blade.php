
<form wire:submit.prevent="submit" x-data="{ id: $id('compose') }">
    <div class="flex">
        <div class="flex-shrink-0 mr-4">
            <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="{{ auth()->user()->name }}"
                class="h-10 w-10 rounded-full">
        </div>
        <div class="min-w-0 flex-1">
            <div>
                <label :for="id" class="sr-only">
                    Comment
                </label>
                <textarea :id="id" rows="3" placeholder="Write something…" wire:model.defer="text"
                    class="shadow-sm block w-full p-2 focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md @error('text') border-red-500 @enderror"
                ></textarea>
                @error('text')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="mt-3 flex items-center justify-between">
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Comment
                </button>
            </div>
        </div>
    </div>
</form>
