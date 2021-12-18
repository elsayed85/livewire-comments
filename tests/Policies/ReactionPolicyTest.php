<?php

use Spatie\LivewireComments\Tests\Support\Models\Post;
use Spatie\LivewireComments\Tests\Support\Models\User;

beforeEach(function () {
    $this->currentUser = login();

    Post::factory()->create()->comment('a comment');

    $this->comment = latestComment();
});

it('will allow to delete reactions that the user created', function () {
    $this->comment->react('👍');
    $reactionByCurrentUser = latestReaction();

    $anotherUser = User::factory()->create();
    $this->comment->react('👍', $anotherUser);
    $reactionByAnotherUser = latestReaction();

    expect($this->currentUser->can('delete', $reactionByCurrentUser))->toBeTrue();
    expect($this->currentUser->can('delete', $reactionByAnotherUser))->toBeFalse();
});
