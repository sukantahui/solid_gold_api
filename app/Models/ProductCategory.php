<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCategoryFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected $casts = [
        'inforce' => 'boolean',
        // ... other casts
    ];

    protected $attributes = [
        'inforce' => true
    ];
}
