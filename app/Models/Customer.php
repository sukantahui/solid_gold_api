<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'customer_category_id',
    //     'customer_name',
    //     'mailing_name',
    //     'email',
    //     'phone',
    //     'mobile1',
    //     'mobile2',
    //     'whatsapp',
    //     'address',
    //     'pin_code',
    //     'opening_gold_balance',
    //     'opening_cash_balance',
    //     'active',
    //     'order_active',
    //     'bill_active',
    //     'job_active',
    //     'inforce',
    // ];

    protected $casts = [
        'active' => 'boolean',
        'order_active' => 'boolean',
        'bill_active' => 'boolean',
        'job_active' => 'boolean',
        'inforce' => 'boolean',
        // 'opening_gold_balance' => 'decimal:3',
        // PHP/Laravel is handling the decimal value cautiously to avoid precision loss, so use string for decimal
        'opening_gold_balance' => 'float',
    ];

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at
            ->timezone('Asia/Kolkata')  // Convert to IST
            ->format('d/m/Y h:i A');   // Indian date/time format
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CustomerCategory::class, 'customer_category_id');
    }
}
