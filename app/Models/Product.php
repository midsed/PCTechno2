<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'quantity_available',
        // keep is_archived if your DB has it, but we won’t use it in UI
        'is_archived',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity_available' => 'int',
        'is_archived' => 'bool',
    ];
}
