<?php

namespace Spatie\LivewireComments\Policies;

use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;

class CommentPolicy
{
    /**
     * @param CanComment|Model $commentator
     * @param Model $commentableModel
     *
     * @return bool
     */
    public function create(Model $commentator, Model $commentableModel): bool
    {
        return true;
    }

    /**
     * @param CanComment|Model $commentator
     * @param Model $commentableModel
     *
     * @return bool
     */
    public function update(Model $commentator, Comment $comment): bool
    {
        return $comment->madeBy($commentator);
    }

    /**
     * @param CanComment|Model $commentator
     * @param Model $commentableModel
     *
     * @return bool
     */
    public function delete(Model $commentator, Comment $comment): bool
    {
        return $comment->madeBy($commentator);
    }

    /**
     * @param CanComment|Model $commentator
     * @param Model $commentableModel
     *
     * @return bool
     */
    public function react(Model $commentator, Model $commentableModel): bool
    {
        return true;
    }
}
