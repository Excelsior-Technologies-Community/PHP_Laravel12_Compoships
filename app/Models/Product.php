<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Compoships, HasFactory;

    protected $fillable = [
        'region',
        'store_code',
        'sku',
        'name',
        'price',
    ];

    public function store()
    {
        return $this->belongsTo(
            Store::class,
            ['region', 'store_code'],
            ['region', 'code']
        );
    }
}
