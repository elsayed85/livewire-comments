<section>
    <div class="comments-wrapper">
        @include('comments::livewire.partials.commentsTitle')
        <div class="comments-body">
            <div>
                @if ($comments->count())
                @foreach($comments as $comment)
                <livewire:comments-comment :key="$comment->id" :comment="$comment" />
                @endforeach
                {{ $comments->links() }}
                @else
                <p> {{ __('comments-livewire::comments.no_comments_yet') }}</p>
                @endif
            </div>
        </div>
    </div>
    @include('comments::livewire.partials.createComment')

    {{-- @todo Determine how we're going to load assets --}}
    <style>
        {!! file_get_contents(base_path('vendor/spatie/laravel-comments-livewire/resources/css/comments.css')) !!}
    </style>
    @include('comments::livewire.partials.scripts')
</section>
