<?php

namespace App\View\Components\Tables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Td extends Component
{
    public $textWrap;

    /**
     * Create a new component instance.
     */
    public function __construct($wrap = false)
    {
        $this->textWrap = $wrap;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tables.td');
    }
}
