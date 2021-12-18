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

    public function removeReaction(string $reaction)
    {
        $this->comment->removeReaction($reaction);
    }

    public function render()
    {
        return view('comments::reactions');
    }
}
