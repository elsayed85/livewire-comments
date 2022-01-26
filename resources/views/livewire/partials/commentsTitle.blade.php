<div class="px-4 py-5 ">
    <h2 class="text-lg font-medium text-gray-900">Comments</h2>

    @auth
        @if (config('comments.notifications.enabled'))
            <input wire:model="updatesViaMail" type="checkbox"> Send updates via mail
        @endif
    @endauth
</div>
