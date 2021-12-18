<?php

namespace Spatie\LivewireComments\Tests\Support\Policies;

use Illuminate\Database\Eloquent\Model;
use Spatie\LivewireComments\Policies\CommentPolicy;

class DenyCommentCreationPolicy extends CommentPolicy
{
    public function create(Model $user, Model $commentableModel): bool
    {
        return false;
    }
}
