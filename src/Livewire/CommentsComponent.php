<?php

namespace Spatie\LivewireComments\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class CommentsComponent extends Component
{
    use WithPagination;

    /** @var \Spatie\Comments\Models\Concerns\HasComments */
    public $model;

    public string $text = '';

    public bool $sendNotifications = true;

    public function getListeners()
    {
        return [
            'delete' => '$refresh',
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
        $this->emit('comment');
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
