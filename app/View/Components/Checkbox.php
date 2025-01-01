<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $id;
    public $name;
    public $value;
    public $checked;
    public $label;

    public function __construct($id, $name, $value = null, $checked = false, $label = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.checkbox');
    }
}
