<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomVoucher extends Model
{
    /** @use HasFactory<\Database\Factories\CustomVoucherFactory> */
    use HasFactory;
    protected $guarded = ['id'];
}
