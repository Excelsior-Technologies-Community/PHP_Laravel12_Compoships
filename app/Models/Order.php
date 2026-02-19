<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class Order extends Model
{
    use Compoships;

    protected $fillable = [
        'order_no',
        'store_id',
        'customer_name'
    ];

    public function items()
    {
        return $this->hasMany(
            OrderItem::class,
            ['order_no', 'store_id'],
            ['order_no', 'store_id']
        );
    }
}
