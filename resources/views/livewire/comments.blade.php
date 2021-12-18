<section>
    <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
        <div class="divide-y divide-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Comments</h2>
            </div>
            <div class="px-4 py-6 sm:px-6">
                <div class="space-y-8">
                    @if ($comments->count())
                        @foreach($comments as $comment)
                            <livewire:comment :comment="$comment" :key="$comment->id" />
                        @endforeach

                        {{ $comments->links() }}
                    @else
                        <p>No comments yet</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-6 sm:px-6">
            @auth
                <div class="flex">
                    <div class="flex-shrink-0 mr-4">
                        <img class="h-10 w-10 rounded-full" src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="{{ auth()->user()->name }}">
                    </div>
                    <div class="min-w-0 flex-1">
                        <x-comments-form
                            submitMethod="createComment"
                            fieldName="newCommentText"
                        />
                    </div>
                </div>
            @endauth

            @guest
                <p>Log in to comment</p>
            @endguest
        </div>
    </div>
</section>
