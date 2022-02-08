<?php

namespace App\View\Components;

use Illuminate\View\Component;

class App extends Component
{
  public $main_title;

  public function __construct($main_title)
  {
    $this->main_title = $main_title;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('backend.layouts.app');
  }
}
