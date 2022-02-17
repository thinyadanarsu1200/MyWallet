<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Wallet;

class WalletController extends Controller
{
  public function index()
  {
    return view('backend.wallet.index');
  }

  public function showWalletList()
  {
    if (request()->ajax()) {
      $limit = request('limit', 5);
      $field = request('field', 'id');
      $direction = request('direction', null);

      $wallets = Wallet::select(['wallets.*', 'users.name as user_name,users.email as user_email,users.phone as user_phone,users.image as user_image'])
        ->join('users', 'wallets.user_id', '=', 'users.id')
        ->orderBy($field, $direction ?? 'asc')
        ->filter(request(['search']))
        ->paginate($limit)
        ->withQueryString();
      return view('components.backend.wallet-table', compact('wallets', 'field', 'direction'))->render();
    }

    return redirect()->route('admin.wallet');
  }

}
