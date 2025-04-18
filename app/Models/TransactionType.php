<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionTypeFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function goldTransactions()
    {
        return $this->hasMany(GoldTransaction::class);
    }
}
