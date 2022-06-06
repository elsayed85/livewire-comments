<?php

use Spatie\Comments\Notifications\PendingCommentNotification;
use DanPalmieri\LivewireComments\Tests\Support\Models\Post;
use DanPalmieri\LivewireComments\Tests\Support\Models\User;
use DanPalmieri\LivewireComments\Tests\Support\Policies\DenyCommentCreationPolicy;

beforeEach(function () {
    $this->currentUser = login();

    $this->post = Post::factory()->create();

    Spatie\Once\Cache::getInstance()->flush();
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

it('will allow users that approve comments to update comments by other users', function () {
    $comment = $this->post->comment('comment');

    $admin = User::factory()->create();
    PendingCommentNotification::sendTo(fn () => $admin);

    expect($admin->can('update', $comment))->toBeTrue();
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

it('will allow users that approve comments to delete comments by other users', function () {
    $comment = $this->post->comment('comment');

    $admin = User::factory()->create();
    PendingCommentNotification::sendTo(fn () => $admin);

    expect($admin->can('delete', $comment))->toBeTrue();
});

it('will allow an approved comment to be seen by anyone', function () {
    $comment = $this->post->comment('comment');

    expect($comment->isApproved())->toBeTrue();

    expect($this->currentUser->can('see', $comment))->toBeTrue();

    $anotherUser = User::factory()->create();
    expect($anotherUser->can('see', $comment))->toBeTrue();
});

it('will allow pending comments to be seen by the user that made the comment', function () {
    config()->set('comments.automatically_approve_all_comments', false);
    $comment = $this->post->comment('comment');
    expect($comment->isApproved())->toBeFalse();

    $anotherUser = User::factory()->create();

    expect($this->currentUser->can('see', $comment))->toBeTrue();
    expect($anotherUser->can('see', $comment))->toBeFalse();
});

it('will allow pending comments to be seen by the users that can approve comments', function () {
    config()->set('comments.automatically_approve_all_comments', false);

    $comment = $this->post->comment('comment');
    expect($comment->isApproved())->toBeFalse();

    $anotherUser = User::factory()->create();

    PendingCommentNotification::sendTo(fn () => $anotherUser);
    Spatie\Once\Cache::getInstance()->flush();

    expect($anotherUser->can('see', $comment))->toBeTrue();
});
