<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  public function index()
  {
    return view('backend.user.index');
  }

  public function create()
  {
    return view('backend.user.create');
  }

  public function showUserList()
  {
    if (request()->ajax()) {
      $limit = request('limit', 5);
      $field = request('field', 'id');
      $direction = request('direction', null);
      $users_id = request('users_id', []);
      $users_id = $users_id ? explode(',', $users_id) : [];
      $users = User::orderBy($field, $direction ?? 'asc')
        ->filter(request(['search']))
        ->paginate($limit)
        ->withQueryString();
      return view('components.backend.usertable', compact('users', 'field', 'direction', 'users_id'))->render();
    }
    return redirect()->route('admin.user.index');
  }

  public function destroySelected($users_id)
  {

    $users_id = $users_id ? explode(',', $users_id) : [];

    foreach ($users_id as $user_id) {
      $users_id = User::where('id', $user_id);

      if ($users_id) {
        $users_id->delete();
      } else {
        return response()->json("no user data found!");
      }
    }

    return response()->json(["status" => "Success", 'message' => "User is deleted successfully"]);
  }

  public function store(StoreUser $request)
  {
    $attributes = $request->validated();
    DB::beginTransaction();
    try {
      if ($request->hasFile('image')) {
        $attributes['image'] = $request->file('image')->store('user/profile');
        $profile_image_path = $attributes['image'];
      }

      $user = User::create($attributes);

      // Create Wallet
      Wallet::firstOrCreate([
        'user_id' => $user->id,
      ],
        [
          'account_number' => UUIDGenerate::accountNumber(),
          'amount' => 0,
        ]);

      DB::commit();
      return redirect()->route('admin.user.store')->with('create', 'User is created successfully');
    } catch (Exception $e) {
      if ($profile_image_path && file_exists('storage/' . $profile_image_path)) {
        Storage::disk('public')->delete($profile_image_path);
      }
      DB::rollBack();
      return redirect()->route('admin.user.create')->with('error', 'Something went wrong');
    }

  }

  public function edit($id)
  {
    $user = User::findOrFail($id);
    return view('backend.user.edit', compact('user'));
  }

  public function update(UpdateUser $request, $id)
  {
    $user = User::findOrFail($id);
    $attributes = $request->validated();

    // update password
    if ($request->password && strlen($request->password) >= 6) {
      $attributes['password'] = $request->password;
    } else if ($request->password && strlen($request->password) < 6) {
      return back()->withErrors(['password' => 'Password must be at least 6 characters!']);
    }

    // delete old image
    if ($request->delete_profile_image) {
      if (file_exists('storage/' . $request->delete_profile_image)) {
        Storage::disk('public')->delete($request->delete_profile_image);
        $attributes['image'] = null;
      }
    }

    // update old image
    if ($request->hasFile('image')) {
      if (file_exists('storage/' . $user->image)) {
        Storage::disk('public')->delete($user->image);
      }
      $attributes['image'] = $request->file('image')->store('user/profile');
    }

    $user->update($attributes);

    return redirect()->route('admin.user.index')->with('update', 'User is updated successfully!');
  }

  public function destroy($delete_id)
  {
    $user = User::find($delete_id);

    if (!$user) {
      return response()->json("No user found");
    }

    if (file_exists($user->image && 'storage/' . $user->image)) {
      Storage::disk('public')->delete($user->image);
    }
    $user->delete();
    return response()->json(["status" => "Success", 'message' => "User is deleted successfully"]);
  }
}
