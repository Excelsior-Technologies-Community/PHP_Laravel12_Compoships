<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use Compoships, HasFactory, SoftDeletes;

    protected $fillable = [
        'order_no',
        'store_id',
        'product_name',
        'qty',
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
