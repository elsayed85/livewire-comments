<?php

namespace Spatie\LivewireComments\Policies;

use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Reaction;

class ReactionPolicy
{
    public function delete(Model $user, Reaction $reaction): bool
    {
        return $reaction->user_id === $user->id;
    }
}
