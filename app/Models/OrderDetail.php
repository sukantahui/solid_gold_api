<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    /** @use HasFactory<\Database\Factories\OrderDetailFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
