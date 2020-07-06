<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BoardIndex extends Component
{
    /**
     * Boards.
     *
     * @var array
     */
    public $boards;

    /**
     * Create the component instance.
     *
     * @param  array  $boards
     * @return void
     */
    public function __construct($boards)
    {
        $this->boards = $boards;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.board-index');
    }
}
