<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceCode extends Model
{
    /** @use HasFactory<\Database\Factories\PriceCodeFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productRates()
    {
        return $this->hasMany(ProductRate::class);
    }
}
