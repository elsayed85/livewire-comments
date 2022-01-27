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
    @include('comments::livewire.partials.scripts')

    <style>
        .comments-wrapper> :not([hidden])~ :not([hidden]) {
            --tw-divide-y-reverse: 0;
            border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
            border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
            --tw-divide-opacity: 1;
            border-color: rgb(229 231 235 / var(--tw-divide-opacity));
        }

        .comments-body{
            padding: 1.5rem 0;
        }

        .comments-body:first-child> * + *{
            margin-left: 2rem;
        }
    </style>
</section>