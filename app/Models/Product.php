<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function priceCode()
    {
        return $this->belongsTo(PriceCode::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function productRates()
    {
        return $this->hasManyThrough(
            ProductRate::class,
            PriceCode::class,
            'id', // Foreign key on PriceCode table
            'price_code_id', // Foreign key on ProductRate table
            'price_code_id', // Local key on Product table
            'id' // Local key on PriceCode table
        );
    }
}
