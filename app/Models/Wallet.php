<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  // public function getAmountAttribute($amount)
  // {
  //   return number_format($amount, 2);
  // }

  public function scopeFilter($query, array $filters)
  {
    // $query->when($filters['search'] ?? false, function ($query, $search) {
    //   $query->where('account_number', 'like', "%$search%")
    //     ->orWhere('amount', 'like', "%$search%")
    //     ->orWhereHas('user', function ($query) use ($search) {
    //       $query->where('name', 'like', "%$search%")
    //         ->orWhere('email', 'like', "%$search%")
    //         ->orWhere('phone', 'like', "%$search%");
    //     });
    // });

    $query->when($filters['search'] ?? false, function ($query, $search) {
      $query->where('account_number', "%$search%")
        ->OrWhere('amount', "$search")
        ->orWhere('user', function ($query) use ($search) {
          $query->orWhere('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('phone', 'like', "%$search%");
        });
    });

  }

}
