<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

  public function edit()
  {
    $user = auth()->guard('web')->user();
    return view('frontend.edit-profile', compact('user'));
  }

  public function update(UpdateProfile $request)
  {
    $user = auth()->guard('web')->user();
    $attributes = $request->validated();

    // update old image
    if ($request->hasFile('image')) {
      if (file_exists('storage/' . $user->image)) {
        Storage::disk('public')->delete($user->image);
      }
      $attributes['image'] = $request->file('image')->store('user/profile');
    }

    // update old cover image
    if ($request->hasFile('cover_image')) {
      if (file_exists('storage/' . $user->cover_image)) {
        Storage::disk('public')->delete($user->cover_image);
      }
      $attributes['cover_image'] = $request->file('cover_image')->store('user/cover');
    }

    $user->update($attributes);

    return redirect()->route('profile')->with('update', 'Your profile is updated successfully');

  }

  // Change Password
  public function changePassword()
  {
    return view('frontend.change-password');
  }

  //Change Password Action
  public function changePasswordAction($id, UpdatePassword $request)
  {
    $user = User::findOrFail($id);
    $user->update([
      'password' => $request->password,
    ]);

    return redirect()->route('profile')->with('update', 'Your password is updated successfully');
  }

  public function transfer()
  {
    return view('frontend.transfer');
  }

  // Logout
  // public function destroy(Request $request)
  // {
  //   auth()->user()->logout();

  //   $request->session()->invalidate();

  //   $request->session()->regenerateToken();

  //   return response()->json(['message' => 'logout successfully']);
  // }
}
