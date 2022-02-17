<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'phone' => 'required|min:7|max:11|unique:users,phone',
      'password' => 'required|min:6|max:8',
      'image' => 'image|mimes:png,jpg,jpeg',
    ];
  }
}
