<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use Compoships, HasFactory;

    protected $fillable = [
        'region',
        'code',
        'name',
        'location',
    ];

    public function products()
    {
        return $this->hasMany(
            Product::class,
            ['region', 'store_code'],
            ['region', 'code']
        );
    }
}
