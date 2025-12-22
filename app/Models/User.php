<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use Notifiable;

  protected $primaryKey = 'user_id';
  public $incrementing = true;
  protected $keyType = 'int';

  protected $fillable = ['full_name','role','username','email','password'];
  protected $hidden = ['password','remember_token'];

  public function logs() {
    return $this->hasMany(Log::class, 'user_id', 'user_id');
  }

  public function isRole(string $role): bool {
    return $this->role === $role;
  }
}
