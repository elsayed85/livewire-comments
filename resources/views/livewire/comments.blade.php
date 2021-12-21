<section>


    <div class="">
        <div class="divide-y divide-gray-200">
            <div class="px-4 py-5 ">
                <h2 class="text-lg font-medium text-gray-900">Comments</h2>
            </div>
            <div class=" py-6">
                <div class="space-y-8">
                    @if ($comments->count())
                        @foreach($comments as $comment)
                            <livewire:comments-comment :key="$comment->id" :comment="$comment"
                                                       :primaryColor="$primaryColor"/>
                        @endforeach

                        {{ $comments->links() }}
                    @else
                        <p>No comments yet</p>
                    @endif
                </div>
            </div>
        </div>

        @include('comments::livewire.partials.newComment')
    </div>
</section>
