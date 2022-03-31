<?php

use Livewire\Livewire;
use Spatie\Comments\Models\Comment;
use Spatie\LivewireComments\Livewire\CommentComponent;

it('can mount the render the comment component', function () {
    $comment = Comment::factory()->create();

    Livewire::test(CommentComponent::class, ['comment' => $comment])->assertSuccessful();
});
