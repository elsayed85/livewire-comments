<?php

namespace Spatie\LivewireComments\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class CommentsComponent extends Component
{
    use WithPagination;

    /** @var \Spatie\Comments\Models\Concerns\HasComments */
    public $model;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public $newCommentText = '';

    protected $rules = [
        'newCommentText' => 'required',
    ];

    public function createComment()
    {
        $comment = $this->model->comment($this->newCommentText);

        $comment->save();

        $this->newCommentText = '';

        $this->goToPage(1);
    }

    public function render()
    {
        $comments = $this->model
            ->comments()
            ->with('user', 'nestedComments.user', 'reactions', 'reactions.user', 'nestedComments.reactions', 'nestedComments.reactions.user')
            ->paginate(10);

        return view('comments::comments', [
            'comments' => $comments,
        ]);
    }
}
