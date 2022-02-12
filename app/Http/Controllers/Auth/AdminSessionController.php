<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSessionController extends Controller
{
  public function create()
  {
    return view('auth.admin_login');
  }

  public function store(LoginRequest $request)
  {

    $request->authenticate('admin');

    $admin = auth()->guard('admin')->user(); //() returns can create/update
    $admin->ip = $request->ip();
    $admin->user_agent = $request->server('HTTP_USER_AGENT');
    $admin->update();

    $request->session()->regenerate();

    return redirect('/admin');
  }

  public function destroy(Request $request)
  {
    Auth::guard('admin')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return response()->json(['message' => 'logout successfully']);
  }

  // public function authenticate(Request $request, $user)
  // {
  //   return $user;
  //   $user->ip = $request->ip();
  //   $user->user_agent = $request->user_agent();
  //   $user->update();
  //   return redirect(RouteServiceProvider::ADMINPANEL);
  // }
}
