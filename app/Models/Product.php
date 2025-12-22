<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $primaryKey = 'product_id';

  protected $fillable = ['product_name','description','price','quantity_available','is_archived'];

  public function transactions() {
    return $this->hasMany(Txn::class, 'product_id', 'product_id');
  }
}
