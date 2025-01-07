<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FancyCheckbox extends Component
{
    public $label;
    public $name;
    public $isChecked;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $isChecked = false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->isChecked = $isChecked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.fancy-checkbox');
    }
}
