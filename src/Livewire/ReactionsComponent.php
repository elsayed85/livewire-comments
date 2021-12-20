<?php

namespace Spatie\LivewireComments\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ReactionsComponent extends Component
{
    //use AuthorizesRequests;

    /** @var \Spatie\Comments\Models\Comment */
    public $comment;

    public function react(string $reaction)
    {
        //$this->authorize('update', $this->comment);

        $this->comment->react($reaction);

        $this->emitUp('refresh');
    }

    public function deleteReaction(string $reaction)
    {
        $this->comment->deleteReaction($reaction);
    }

    public function render()
    {
        return view('comments::reactions');
    }
}
