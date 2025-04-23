<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\GoldTransactionFactory> */
    use HasFactory;
    protected $guarded = ['id'];
   
    /**
     * Get the customer associated with the transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the agent associated with the transaction.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Get the order master associated with the transaction.
     */
    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class);
    }

    /**
     * Get the transaction type associated with the transaction.
     */
    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function scopeInforce($query)
    {
        return $query->where('inforce', true);
    }

    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('transaction_date', $date);
    }

    protected $casts = [
        'transaction_date' => 'date',
        'gold_value' => 'decimal:3',
        'gold_rate' => 'integer',
        'gold_cash' => 'integer',
        'inforce' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
