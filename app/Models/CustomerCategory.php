<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerCategory extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerCategoryFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
   

    public function productRates()
    {
        return $this->hasMany(ProductRate::class);
    }
}
