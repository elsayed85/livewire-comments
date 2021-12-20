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
                            <livewire:comments-comment :comment="$comment" :key="$comment->id"/>
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
                    <livewire:comments-compose :on-submit="'comment:' . $model->id" />
                @endauth

                @guest
                    <p>Log in to comment</p>
                @endguest
            </div>
        @endcan
    </div>
</section>
