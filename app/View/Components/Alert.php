<?php

namespace App\View\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(public string $type)
    {
    }

    public function render(): Renderable
    {
        return view('components.alert');
    }
}
