<?php

namespace Spatie\LivewireComments\View\Components;

use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class Scripts extends Component
{
    public function __construct(
        public bool $withoutSimpleMde = false,
    ) {
    }

    public function render()
    {
        return view('comments::components.scripts', [
            'script' => new HtmlString(
                file_get_contents(__DIR__ . '/../../../resources/js/comments.js')
            ),
        ]);
    }
}
