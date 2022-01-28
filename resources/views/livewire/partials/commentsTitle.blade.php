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

    <style>
        #mail-checkbox:checked+label {
            background: #4338ca;
        }

        #mail-checkbox:checked+label:after {
            left: calc(100% - 1.25rem);
        }

        #mail-checkbox {
            width: 0;
            height: 0;
            display: hidden;
        }

        #mail-checkbox[type='checkbox'] {
            
            -webkit-appearance: none;
            appearance: none;
            display: hidden;
            position: absolute;
            left: 1223455px;
        }

        #mail-checkbox+label {
            cursor: pointer;
            width: 3rem;
            height: 1.5rem;
            background-color: rgb(226 232 240);
            display: block;
            border-radius: 999999px;
            position: relative;
        }

        #mail-checkbox+label:after {
            content: '';
            position: absolute;
            top: .25rem;
            left: .25rem;
            width: 1rem;
            height: 1rem;
            background-color: white;
            border-radius: 999999px;
            transition: left 0.25s;
        }


        .mail-checkbox-wrapper {
            display: flex;
            align-content: center;
            gap: 0.75rem;
            position: relative;
        }

        .title-wrapper {
            padding: 1.24rem 1rem;
            display: flex;
            justify-content: space-between;
        }

        .title-wrapper>h2 {
            font-size: 1.125rem;
            line-height: 1.75rem;
            font-weight: 500;
            color: color: rgb(17 24 39);
        }
    </style>
</div>