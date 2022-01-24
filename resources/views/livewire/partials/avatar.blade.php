<img
    class="h-10 w-10 rounded-full"
    src="https://www.gravatar.com/avatar/{{ auth()->user()->email }}"
    alt="{{ isset($comment) ? $comment->user->name : auth()->user()->name }}"
>
