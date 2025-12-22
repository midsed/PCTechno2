<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $table = 'sales';
  protected $primaryKey = 'sales_id';

  protected $fillable = ['transaction_id','total_amount','payment_method','sales_date'];

  public function transaction() {
    return $this->belongsTo(Txn::class, 'transaction_id', 'transaction_id');
  }
}
