<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Compoships, HasFactory, SoftDeletes;

    protected $fillable = [
        'order_no',
        'store_id',
        'customer_name',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(
            OrderItem::class,
            ['order_no', 'store_id'],
            ['order_no', 'store_id']
        );
    }

    public function getTotalQtyAttribute()
    {
        return $this->items->sum('qty');
    }

    public function getTotalItemsAttribute()
    {
        return $this->items->count();
    }
}
