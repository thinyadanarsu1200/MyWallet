<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'phone' => 'required|min:9|max:11',
      'amount' => 'required|integer|min:200',
    ];
  }

  public function prepareForValidation()
  {
    if ($this->phone) {
      $user = User::where('phone', $this->phone)->first();
      if ($this->phone == auth()->user()->phone) {
        $this->session()->flash('status', 'fail');
        $this->session()->flash('message', "You cannot transfer your account");
      } else if (!$user) {
        $this->session()->flash('status', 'fail');
        $this->session()->flash('message', "There is no user found");
      } else if ($user) {
        $this->session()->flash('status', 'success');
        $this->session()->flash('message', $user->name);
      }
    }

    if ($this->description) {
      $this->session()->flash('description-status', $this->description);
    }
  }
}
