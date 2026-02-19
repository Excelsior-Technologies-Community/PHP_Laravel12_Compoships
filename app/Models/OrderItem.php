<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class OrderItem extends Model
{
    use Compoships;

    protected $fillable = [
        'order_no',
        'store_id',
        'product_name',
        'qty'
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            ['order_no', 'store_id'],
            ['order_no', 'store_id']
        );
    }
}
