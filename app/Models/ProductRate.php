<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRate extends Model
{
    /** @use HasFactory<\Database\Factories\ProductRateFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function customerCategory()
    {
        return $this->belongsTo(CustomerCategory::class);
    }

    public function priceCode()
    {
        return $this->belongsTo(PriceCode::class);
    }
}
