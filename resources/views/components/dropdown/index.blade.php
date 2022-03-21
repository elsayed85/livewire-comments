<div
     class="comments-dropdown"
     x-cloak
     x-data="{ dropdownOpen: false, deleteConfirm: false }"
     @click.outside="dropdownOpen = deleteConfirm = false"
>
     <button class="comments-dropdown-trigger" type="button" @click="dropdownOpen = !dropdownOpen">
          <span x-show="!dropdownOpen">
               @include('comments::livewire.svgs.menu')
          </span>
          <span x-show="dropdownOpen">
               @include('comments::livewire.svgs.close')
          </span>
    </button>
     <!-- @todo Remove delete confirm code -->
     {{ $slot }}
</div>
