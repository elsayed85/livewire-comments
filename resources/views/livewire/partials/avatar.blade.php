<img
    class="h-10 w-10 rounded -full"
    src="{{ isset($comment) ? $comment->commentatorProperties()->avatar : 'default.png' }}"
    alt="{{ isset($comment) ? $comment->commentatorProperties()->name : auth()->user()->commentatorProperties()->name }}"
>
