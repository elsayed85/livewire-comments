<?php

namespace Spatie\LivewireComments\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ComposeComponent extends Component
{
    use AuthorizesRequests;

    public string $onSubmit;

    public string $text;

    public function mount(string $onSubmit, ?string $text = '')
    {
        $this->onSubmit = $onSubmit;

        $this->text = $text;
    }

    public function submit()
    {
        $this->validate([
            'text' => 'required',
        ]);

        ray($this->onSubmit, $this->text);

        $this->emit($this->onSubmit, $this->text);

        $this->text = '';
    }

    public function render()
    {
        return view('comments::livewire.compose');
    }
}
