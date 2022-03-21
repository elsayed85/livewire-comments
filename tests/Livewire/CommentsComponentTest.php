<?php

use Livewire\Livewire;
use Spatie\Comments\Models\Comment;
use Spatie\LivewireComments\Livewire\CommentsComponent;
use Spatie\LivewireComments\Tests\Support\Models\Post;

it('can mount the render the comments component for a model without comments', function () {
    $post = Post::factory()->create();

    Livewire::test(CommentsComponent::class, ['model' => $post])->assertSuccessful();
});

it('can mount the render the comments component for a model with comments', function () {
    $comment = Comment::factory()->create();

    Livewire::test(CommentsComponent::class, ['model' => $comment->commentable])->assertSuccessful();
});
