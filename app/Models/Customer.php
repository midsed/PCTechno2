<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'contact_information',
        'address',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'bool',
    ];
}
