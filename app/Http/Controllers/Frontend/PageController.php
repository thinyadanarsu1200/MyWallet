<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
  public function home()
  {
    return view('frontend.home');
  }

  public function profile()
  {
    $user = auth()->guard('web')->user();
    return view('frontend.profile', compact('user'));
  }
}
