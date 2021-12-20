<section>
    <div class="">
        <div class="divide-y divide-gray-100">
            <div class="px-4 py-5 ">
                <h2 class="text-lg font-medium text-gray-900">Comments</h2>
            </div>
            <div class=" py-6">
                <div class="space-y-8">
                    @if ($comments->count())
                        @foreach($comments as $comment)
                            <livewire:comments-comment :key="$comment->id" :comment="$comment" />
                        @endforeach

                        {{ $comments->links() }}
                    @else
                        <p>No comments yet</p>
                    @endif
                </div>
            </div>
        </div>

        @can('createComment', $model)
            <div class="bg-gray-50 px-4 py-6 sm:px-6">
                @auth
                    <div class="flex">
                        <div class="flex-shrink-0 mr-4">
                            <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="{{ auth()->user()->name }}"
                                class="h-10 w-10 rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <livewire:comments-compose :on-submit="'comment:' . $model->id" />
                        </div>
                    </div>
                @endauth

                @guest
                    <p>Log in to comment</p>
                @endguest
            </div>
        @endcan
    </div>
</section>
