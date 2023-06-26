<?php

namespace App\View\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(public string $title)
    {
    }

    public function render(): Renderable
    {
        return view('components.card');
    }
}
