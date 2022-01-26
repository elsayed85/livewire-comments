<div class="px-4 py-5 flex justify-between">
    <h2 class="text-lg font-medium text-gray-900">Comments</h2>

    @auth
    @if (config('comments.notifications.enabled'))
    <div class="flex items-center gap-3">
        Send updates via mail
        <input id="mail-checkbox" class="w-0 h-0 hidden" wire:model="updatesViaMail" type="checkbox">
        <label for="mail-checkbox"
            class=" cursor-pointer w-12 h-6 bg-slate-200 block rounded-full relative after:absolute after:top-1 after:left-1 after:w-4 after:h-4 after:bg-white after:rounded-full after:transition-all"></label>

    </div>

    @endif
    @endauth

    <style>
        #mail-checkbox:checked+label {
            background: #4338ca;
        }

        #mail-checkbox:checked+label:after {
            left: calc(100% - .25rem);
            transform: translateX(-100%);
        }

        label:active:after {
            width: 130px;
        }
    </style>
</div>