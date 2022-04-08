<?php

use Livewire\Livewire;
use Spatie\Comments\Enums\NotificationSubscriptionType;
use Spatie\Comments\Models\Comment;
use Spatie\LivewireComments\Livewire\CommentsComponent;
use Spatie\LivewireComments\Tests\Support\Models\Post;

beforeEach(function () {
    $this->post = Post::factory()->create();
});

it('can mount the render the comments component for a model without comments', function () {
    Livewire::test(CommentsComponent::class, ['model' => $this->post])->assertSuccessful();
});

it('can mount the render the comments component for a model with comments', function () {
    $comment = Comment::factory()->create();

    Livewire::test(CommentsComponent::class, ['model' => $comment->commentable])->assertSuccessful();
});

it('can create a new comment', function () {
    login();

    Livewire::test(CommentsComponent::class, ['model' => $this->post])
        ->assertSuccessful()
        ->set('text', 'my new comment')
        ->call('comment');

    expect($this->post->comments->first()->original_text)->toBe('my new comment');
});

it('will not render avatars when the option is disabled', function () {
    login();

    Livewire::test(CommentsComponent::class, ['model' => $this->post])
        ->assertSuccessful()
        ->assertSee('avatar');

    config()->set('comments.ui.show_avatars', false);

    Livewire::test(CommentsComponent::class, ['model' => $this->post])
        ->assertSuccessful()
        ->assertDontSee('avatar');
});

it('will not render avatars when the config is enable but turned off on the component', function () {
    login();

    Livewire::test(CommentsComponent::class, ['model' => $this->post, 'hideAvatars' => true])
        ->assertSuccessful()
        ->assertDontSee('avatar');
});

it('supports a read only mode', function () {
    login();

    $comment = $this->post->comment('my comment');
    $comment->comment('another comment');

    Livewire::test(CommentsComponent::class, ['model' => $this->post])
        ->assertSuccessful()
        ->assertSee('Edit')
        ->assertSee('Leave a comment')
        ->assertSee('Leave a reply');

    Livewire::test(CommentsComponent::class, ['model' => $this->post, 'readOnly' => true])
        ->assertSuccessful()
        ->assertDontSee('Edit')
        ->assertDontSee('Leave a comment')
        ->assertDontSee('Leave a reply');
});

it('can subscribe to notifications explicitly', function () {
    $currentUser = login();

    Livewire::test(CommentsComponent::class, ['model' => $this->post])
        ->assertSuccessful()
        ->updateProperty('selectedNotificationSubscriptionType', NotificationSubscriptionType::All->value);

    $type = $currentUser->notificationSubscriptionType($this->post);

    expect($type)->toBe(NotificationSubscriptionType::All);
});


it('will subscribe to participating strategy when making the first comment', function () {
    $currentUser = login();

    Livewire::test(CommentsComponent::class, ['model' => $this->post])
        ->assertSuccessful()
        ->updateProperty('text', 'Here are my thought on using final')
        ->call('comment');

    $type = $currentUser->notificationSubscriptionType($this->post);

    expect($type)->toBe(NotificationSubscriptionType::Participating);
});
