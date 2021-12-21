@can('createComment', $model)
    <div class="bg-gray-50 px-4 py-6 sm:px-6">
        @auth
            <div class="flex">
                <div class="flex-shrink-0 mr-4">
                    <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50"
                         alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full">
                </div>
                <div class="min-w-0 flex-1">
                    <livewire:comments-compose :on-submit="'comment:' . $model->id"
                                               :primaryColor="$primaryColor"/>
                </div>
            </div>
        @endauth

        @guest
            <p>Log in to comment</p>
        @endguest
    </div>
@endcan
