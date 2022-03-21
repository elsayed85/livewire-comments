<?php

use Livewire\Livewire;
use Spatie\Comments\Models\Comment;
use Spatie\LivewireComments\Livewire\CommentComponent;
use Spatie\LivewireComments\Livewire\CommentsComponent;
use Spatie\LivewireComments\Tests\Support\Models\Post;

it('can mount the render the comments component', function() {
    $post = Post::factory()->create();

    Livewire::test(CommentsComponent::class, ['model' => $post])->assertSuccessful();
});
