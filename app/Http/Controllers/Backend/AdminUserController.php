<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin;
use App\Http\Requests\UpdateAdmin;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
  public function index()
  {
    return view('backend.admin-user.index');
  }

  public function create()
  {
    return view('backend.admin-user.create');
  }

  public function showAdminList()
  {
    $limit = request('limit', 5);
    $field = request('field', 'id');
    $direction = request('direction', null);
    $admins_id = request('admins_id', []);
    $admins_id = $admins_id ? explode(',', $admins_id) : [];
    $admins = Admin::orderBy($field, $direction ?? 'asc')
      ->filter(request(['search']))
      ->paginate($limit)
      ->withQueryString();
    return view('components.backend.table', compact('admins', 'field', 'direction', 'admins_id'))->render();
  }

  public function destroySelected($admins_id)
  {

    $admins_id = $admins_id ? explode(',', $admins_id) : [];

    foreach ($admins_id as $admin_id) {
      $admins_id = Admin::where('id', $admin_id);
      if ($admins_id) {
        $admins_id->delete();
      } else {
        return response()->json("no admin data found!");
      }
    }

    return response()->json(["status" => "Success", 'message' => "Admin user is deleted successfully"]);
  }

  public function store(StoreAdmin $request)
  {
    $attributes = $request->validated();

    if ($request->hasFile('image')) {
      $attributes['image'] = $request->file('image')->store('admin/profile');
    } else {
      dd('not include');
    }

    Admin::create($attributes);

    return redirect()->route('admin.admin-user.store')->with('success', 'Employee is created successfully');
  }

  public function edit($id)
  {
    $admin = Admin::findOrFail($id);
    return view('backend.admin-user.edit', compact('admin'));
  }

  public function update(UpdateAdmin $request, $id)
  {
    $admin = Admin::findOrFail($id);
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
      if (file_exists('storage/' . $admin->image)) {
        Storage::disk('public')->delete($admin->image);
      }
      $attributes['image'] = $request->file('image')->store('admin/profile');
    }

    $admin->update($attributes);

    return redirect()->route('admin.admin-user.index')->with('update', 'Admin User is updated successfully!');
  }

  public function destroy($delete_id)
  {
    $admin = Admin::find($delete_id);

    if (!$admin) {
      return response()->json("No admin found");
    }
    $admin->delete();
    return response()->json(["status" => "Success", 'message' => "Admin user is deleted successfully"]);
  }
}
