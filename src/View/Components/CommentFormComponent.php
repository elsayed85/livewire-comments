<?php

namespace Spatie\LivewireComments\View\Components;

use Illuminate\View\Component;

class CommentFormComponent extends Component
{
    public function __construct(
        public string $submitMethod,
        public string $fieldName,
    ) {
    }

    public function render()
    {
        return view('comments::blade.commentForm');
    }
}
