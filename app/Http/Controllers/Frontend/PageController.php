<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateProfile;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
  public function home()
  {
    $amount = auth()->user()->wallet->amount;
    $name = auth()->user()->name;
    return view('frontend.home', compact('amount', 'name'));
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

  public function searchTransferPhone(Request $request)
  {
    $phone = $request->phone;

    if (strlen($phone) < 9) {
      return;
    } else {
      $phone_owner_name = User::where('phone', $phone)->pluck('name');
      return $phone_owner_name;
    }
  }

  public function transferAction(TransferRequest $request)
  {
    $attributes = $request->validated();

    $user = User::where('phone', $request->phone)->first();
    $amount = $request->amount;

    $description = $request->description;

    if ($user && $user->phone !== auth()->user()->phone) {
      return view('frontend.confirm-transaction', compact('user', 'amount', 'description'));
    } else {
      return back();
    }
  }

  public function checkPassword()
  {
    if (!request('password')) {
      return response()->json([
        'status' => 'fail',
        'message' => "Please fill password field",
      ]);
    }

    $user = User::where('id', request('id'))->first();
    if ($user) {
      if (!Hash::check(request('password'), $user->password)) {
        return response()->json([
          'status' => 'fail',
          'message' => "Password is wrong",
        ]);
      } else {
        return response()->json([
          'status' => 'success',
        ]);
      }
    } else {
      return response()->json([
        'status' => 'fail',
        'message' => "Password is wrong",
      ]);
    }

  }

  public function sendTransfer()
  {
    $amount = request('amount');
    $id = request('id');
    $to_phone = request('phone');
    $from_phone = auth()->user()->phone;

    if (request('description')) {
      $description = request('description');
    }

    DB::beginTransaction();
    try {

      $from_account = User::where('phone', $from_phone)->first();
      $to_account = User::where('phone', $to_phone)->first();

      if (!$from_account->wallet || !$to_account->wallet) {
        return back()->with('error', 'something went wrong');
      }
      $from_account->wallet->decrement('amount', $amount);
      $to_account->wallet->increment('amount', $amount);

      $ref_no = UUIDGenerate::refNo();

      $from_account_transaction = new Transaction();
      $from_account_transaction->ref_no = $ref_no;
      $from_account_transaction->trx_id = UUIDGenerate::trxId();
      $from_account_transaction->user_id = $from_account->id;
      $from_account_transaction->type = 2;
      $from_account_transaction->amount = $amount;
      $from_account_transaction->source_id = $to_account->id;
      $from_account_transaction->description = $description;
      $from_account_transaction->save();

      $to_account_transaction = new Transaction();
      $to_account_transaction->ref_no = $ref_no;
      $to_account_transaction->trx_id = UUIDGenerate::trxId();
      $to_account_transaction->user_id = $to_account->id;
      $to_account_transaction->type = 1;
      $to_account_transaction->amount = $amount;
      $to_account_transaction->source_id = $from_account->id;
      $to_account_transaction->description = $description;
      $to_account_transaction->save();

      request()->session()->flash('success-transfer', [
        'receive_user' => $to_account->name,
        'amount' => $amount,
      ]);

      DB::commit();
      return redirect()->route('success-transfer');

    } catch (Exception $e) {
      DB::rollBack();
      return back()->with('error', $e->getMessage());
    }

  }

  public function successTransfer()
  {

    $data = session('success-transfer');

    if (!$data) {
      return;
    }

    $receive_user = $data['receive_user'];
    $amount = $data['amount'];

    return view('frontend.success-transfer', compact('receive_user', 'amount'));
  }

  public function transaction()
  {
    $user = auth()->user();
    $transactions = Transaction::orderby('created_at', 'DESC')->where('user_id', $user->id)->get();

    return view('frontend.transaction', compact('transactions'));
  }

  public function transactionDetail($trx_id)
  {
    $user = auth()->user();
    $transaction = Transaction::with('user', 'source')->where('user_id', $user->id)->where('trx_id', $trx_id)->get();
    return view('frontend.transaction-detail', compact('transaction'));
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
