<?php

namespace DanPalmieri\LivewireComments\Tests\Support\Policies;

use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use DanPalmieri\LivewireComments\Policies\CommentPolicy;

class DenyCommentCreationPolicy extends CommentPolicy
{
    public function create(?CanComment $user): bool
    {
        return false;
    }
}
