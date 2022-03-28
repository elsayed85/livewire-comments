<div
     class="comments-dropdown"
     x-cloak
     x-data="{
        dropdownOpen: false,
        closeDropdown() {
            dropdownOpen = false;
        },
    }"
     @click.outside="dropdownOpen = false"
>
     <button class="comments-dropdown-trigger" type="button" @click="dropdownOpen = !dropdownOpen">
          <span x-show="!dropdownOpen">
               <x-comments::icons.menu />
          </span>
          <span x-show="dropdownOpen">
               <x-comments::icons.close />
          </span>
    </button>
    <div x-show="dropdownOpen" class="comments-dropdown-items">
          {{ $slot }}
     </div>
</div>
