<?php

namespace Spatie\LivewireComments\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class CommentsComponent extends Component
{
    use WithPagination;

    /** @var \Spatie\Comments\Models\Concerns\HasComments */
    public $model;

    public function getListeners()
    {
        return [
            'comment:' . $this->model->id => 'comment',
            'delete' => '$refresh',
        ];
    }

    public function comment(string $text)
    {
        $this->model->comment($text);

        $this->goToPage(1);
    }

    public function render()
    {
        $comments = $this->model
            ->comments()
            ->with([
                'user',
                'nestedComments.user',
                'reactions',
                'reactions.user',
                'nestedComments.reactions',
                'nestedComments.reactions.user',
            ])
            ->paginate(10);

        return view('comments::livewire.comments', [
            'comments' => $comments,
        ]);
    }
}
