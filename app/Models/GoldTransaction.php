<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\GoldTransactionFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }
}
