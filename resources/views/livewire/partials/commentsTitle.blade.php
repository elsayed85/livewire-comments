<div class="title-wrapper">
    <h2>Comments</h2>

    @auth
    @if (config('comments.notifications.enabled'))
    <div class="mail-checkbox-wrapper ">
        Send updates via mail
        <input id="mail-checkbox" wire:model="updatesViaMail" type="checkbox">
        <label for="mail-checkbox"></label>
    </div>

    @endif
    @endauth
</div>
