<?php

use Illuminate\Support\Facades\Auth;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\Models\Reaction;
use DanPalmieri\LivewireComments\Tests\Support\Models\User;
use DanPalmieri\LivewireComments\Tests\Support\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        config()->set('comments.models.user', User::class);
        ray()->newScreen($this->getName());
    })
    ->in(__DIR__);

function login(User $user = null): User
{
    $currentUser = $user ?? User::factory()->create();

    Auth::login($currentUser);

    return $currentUser;
}

function logout(): void
{
    Auth::logout();
}


function latestComment(): ?Comment
{
    return Comment::orderByDesc('id')->first();
}

function latestReaction(): ?Reaction
{
    return Reaction::orderByDesc('id')->first();
}

function registerPolicies(): void
{
    test()->registerPolicies();
}
