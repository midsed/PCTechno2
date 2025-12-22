<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $primaryKey = 'customer_id';

  protected $fillable = ['customer_name','contact_information','address','is_archived'];

  public function transactions() {
    return $this->hasMany(Txn::class, 'customer_id', 'customer_id');
  }
}
