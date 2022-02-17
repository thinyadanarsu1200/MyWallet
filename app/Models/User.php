<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $guarded = [];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getNameAttribute($name)
  {
    return ucwords($name);
  }

  public function setPasswordAttribute($password)
  {
    $this->attributes['password'] = bcrypt($password);
  }

  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? false, fn($query, $search) =>
      $query->where(fn($query) =>
        $query->where('name', 'like', '%' . $search . '%')
          ->orWhere('email', 'like', '%' . $search . '%')
          ->orWhere('phone', 'like', '%' . $search . '%')
      ));
  }

  public function profileImage()
  {
    if ($this->image) {
      return asset('storage/' . $this->image);
    } else {
      return null;
    }
  }

  public function wallet()
  {
    $this->hasOne(Wallet::class, 'user_id', 'id');
  }
}
