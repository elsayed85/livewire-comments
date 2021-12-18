<?php

use Spatie\LivewireComments\Tests\Support\Models\Post;
use Spatie\LivewireComments\Tests\Support\Models\User;
use Spatie\LivewireComments\Tests\Support\Policies\DenyCommentCreationPolicy;

beforeEach(function () {
    $this->currentUser = login();

    $this->post = Post::factory()->create();
});

it('will allow a comment to be created', function () {
    expect($this->currentUser->can('createComment', $this->post))->toBeTrue();
});

it('can use a different policy that will deny comments to be created', function () {
    config()->set('comments.policies.comment', DenyCommentCreationPolicy::class);

    registerPolicies();

    expect($this->currentUser->can('createComment', $this->post))->toBeFalse();
});


it('will allow to update comments that the user created', function () {
    $this->post->comment('comment');
    $commentByCurrentUser = latestComment();

    $anotherUser = User::factory()->create();
    $this->post->comment('comment by another user', $anotherUser);
    $commentByAnotherUser = latestComment();

    expect($this->currentUser->can('update', $commentByCurrentUser))->toBeTrue();
    expect($this->currentUser->can('update', $commentByAnotherUser))->toBeFalse();
});

it('will allow to delete comments that the user created', function () {
    $this->post->comment('comment');
    $commentByCurrentUser = latestComment();

    $anotherUser = User::factory()->create();
    $this->post->comment('comment by another user', $anotherUser);
    $commentByAnotherUser = latestComment();

    expect($this->currentUser->can('delete', $commentByCurrentUser))->toBeTrue();
    expect($this->currentUser->can('delete', $commentByAnotherUser))->toBeFalse();
});
