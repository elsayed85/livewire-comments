<?php

namespace Spatie\LivewireComments\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CommentComponent extends Component
{
    use AuthorizesRequests;

    /** @var \Spatie\Comments\Models\Comment */
    public $comment;

    public $isReplying = false;

    public $isEditing = false;

    public function getListeners()
    {
        return [
            'edit:' . $this->comment->id => 'edit',
            'reply:' . $this->comment->id => 'reply',
            'delete' => '$refresh',
        ];
    }

    public function edit(string $text)
    {
        $this->authorize('update', $this->comment);

        $this->comment->update([
            'original_text' => $text,
        ]);

        $this->isEditing = false;
    }

    public function reply(string $text)
    {
        $this->comment->comment($text);

        $this->comment->load('nestedComments');

        $this->isReplying = false;
    }

    public function deleteComment()
    {
        $this->authorize('delete', $this->comment);

        $this->comment->delete();

        $this->emitUp('delete');
    }

    public function react(string $reaction)
    {
        $this->authorize('react', $this->comment);

        $this->comment->react($reaction);

        $this->comment->load('reactions');
    }

    public function deleteReaction(string $reaction)
    {
        if ($reactionModel = $this->comment->findReaction($reaction)) {
            $this->authorize('delete', $reactionModel);
        }

        $this->comment->deleteReaction($reaction);

        $this->comment->load('reactions');
    }

    public function render()
    {
        return view('comments::livewire.comment');
    }
}
