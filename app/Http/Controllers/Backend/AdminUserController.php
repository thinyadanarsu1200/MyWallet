<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;

class AdminUserController extends Controller
{
  public function index()
  {
    return view('backend.admin-user.index');
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

    return response()->json("Admin user is deleted successfully");
  }
}
