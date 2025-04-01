<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    /** @use HasFactory<\Database\Factories\OrderMasterFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
