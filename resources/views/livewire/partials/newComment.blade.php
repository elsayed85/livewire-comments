@can('createComment', $model)
    <div class="bg-gray-50 px-4 py-6 sm:px-6">
        @auth
            <div class="flex">
                <div class="flex-shrink-0 mr-4">
                    @include('comments::livewire.partials.avatar')
                </div>
                <div class="min-w-0 flex-1">
                    <livewire:comments-compose
                        :onSubmit="'comment:' . $model->id"
                        :primaryColor="$primaryColor"
                        placeholder="Leave a comment"
                    />
                </div>
            </div>
        @endauth

        @guest
            <p>Log in to comment</p>
        @endguest
    </div>
@endcan
