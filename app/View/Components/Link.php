<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public $attributes;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function render()
    {
        return view('components.link');
    }
}