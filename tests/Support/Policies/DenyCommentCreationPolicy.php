<?php

namespace Spatie\LivewireComments\Tests\Support\Policies;

use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\LivewireComments\Policies\CommentPolicy;

class DenyCommentCreationPolicy extends CommentPolicy
{
    public function create(?CanComment $user): bool
    {
        return false;
    }
}
