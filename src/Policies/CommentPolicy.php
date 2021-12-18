<?php

namespace Spatie\LivewireComments\Policies;

use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Comment;

class CommentPolicy
{
    public function create(Model $user, Model $commentableModel): bool
    {
        return true;
    }

    public function update(Model $user, Comment $comment): bool
    {
        return $user->getKey() === $comment->user_id;
    }

    public function delete(Model $user, Comment $comment): bool
    {
        return $user->getKey() === $comment->user_id;
    }

    public function react(Model $user, Model $commentableModel): bool
    {
        return true;
    }
}
