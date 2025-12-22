<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Txn extends Model
{
  protected $table = 'transactions';
  protected $primaryKey = 'transaction_id';

  protected $fillable = ['product_id','customer_id','quantity_sold','transaction_date'];

  public function product() {
    return $this->belongsTo(Product::class, 'product_id', 'product_id');
  }

  public function customer() {
    return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
  }

  public function sale() {
    return $this->hasOne(Sale::class, 'transaction_id', 'transaction_id');
  }
}
