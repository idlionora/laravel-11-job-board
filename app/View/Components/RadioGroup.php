<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RadioGroup extends Component
{
    public function __construct(
        public string $name,
        public array $options,
        public ?bool $allOption = true,
        public ?string $value = null
    )
    {
        //
    }

    public function optionsWithLabels() : array
    {
        return array_is_list($this->options) ? 
            array_combine($this->options, $this->options) 
            : $this->options;

    }

    public function render(): View|Closure|string
    {
        return view('components.radio-group');
    }
}
