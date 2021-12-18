<?php

namespace Spatie\LivewireComments\Support;


use Spatie\LivewireComments\Policies\CommentPolicy;
use Spatie\LivewireComments\Policies\ReactionPolicy;

use Spatie\Comments\Support\Config as BaseConfig;

class Config extends BaseConfig
{
    /** @return class-string<CommentPolicy> */
    public static function getCommentPolicyName(): string
    {
        return config('comments.policies.comment', CommentPolicy::class);
    }

    /** @return class-string<ReactionPolicy> */
    public static function getReactionPolicyName(): string
    {
        return config('comments.policies.reaction', ReactionPolicy::class);
    }
}
