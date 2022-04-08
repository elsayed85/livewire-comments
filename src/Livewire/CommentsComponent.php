<?php

namespace Spatie\LivewireComments\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Comments\Enums\NotificationSubscriptionType;
use Spatie\LivewireComments\Support\Config;

class CommentsComponent extends Component
{
    use WithPagination;

    /** @var \Spatie\Comments\Models\Concerns\HasComments */
    public $model;

    public string $text = '';

    public bool $sendNotifications = true;
    public bool $showAvatars;
    public bool $writable;
    public string $selectedNotificationSubscriptionType = '';

    public function mount(bool $readOnly = false, ?bool $showAvatars = null)
    {
        $this->showAvatars = $showAvatars ?? Config::showAvatars();
        $this->writable = ! $readOnly;
        $this->selectedNotificationSubscriptionType = auth()->user()?->notificationSubscriptionType($this->model)?->value ?? NotificationSubscriptionType::Participating->value;
    }

    public function getListeners()
    {
        return [
            'delete' => '$refresh',
            'reply-created' => 'saveNotificationSubscription',
        ];
    }

    public function updatingSendNotifications(bool $value)
    {
        $value
            ? $this->model->optInOnCommentNotifications(auth()->user())
            : $this->model->optOutOfCommentNotifications(auth()->user());
    }

    public function comment()
    {
        $this->validate(['text' => 'required']);

        $this->model->comment($this->text);

        $this->text = '';
        // @todo This is weird behaviour when your comment appears on a later page.
        // To revisit when we decide how to handle comment sorting.
        $this->goToPage(1);

        $this->saveNotificationSubscription();

        $this->emit('comment');
    }

    public function updatedSelectedNotificationSubscriptionType()
    {
        $this->saveNotificationSubscription();
    }

    public function saveNotificationSubscription()
    {
        ray('saveNotificationSubscription')->green();
        /** @var \Spatie\Comments\Models\Concerns\Interfaces\CanComment $currentUser */
        $currentUser = auth()->user();

        $type = NotificationSubscriptionType::from($this->selectedNotificationSubscriptionType);

        if ($type === NotificationSubscriptionType::None) {
            $currentUser->unsubscribeFromCommentNotifications($this->model);

            return;
        }

        $currentUser->subscribeToCommentNotifications($this->model, NotificationSubscriptionType::from($this->selectedNotificationSubscriptionType));
    }

    public function render()
    {
        $comments = $this->model
            ->comments()
            ->with([
                'commentator',
                'nestedComments.commentator',
                'reactions',
                'reactions.commentator',
                'nestedComments.reactions',
                'nestedComments.reactions.commentator',
            ])
            ->paginate(10);

        return view('comments::livewire.comments', [
            'comments' => $comments,
        ]);
    }
}
